<?php

namespace App\Http\Controllers;

use App\Models\PropertyRequest;
use App\Models\UnitType;
use App\Models\Unit;
use App\Models\Property;
use App\Models\customers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PropertyRequestController extends Controller
{
    /**
     * عرض قائمة طلبات التسكين وقائمة الانتظار مع الإحصائيات والفلاتر
     */
    public function index(Request $request)
    {
        // الإحصائيات العامة للطلبات
        $stats = [
            'total'     => PropertyRequest::count(),
            'pending'   => PropertyRequest::where('status', 'pending')->count(),
            'contacted' => PropertyRequest::where('status', 'contacted')->count(),
            'fulfilled' => PropertyRequest::where('status', 'fulfilled')->count(),
            'cancelled' => PropertyRequest::where('status', 'cancelled')->count(),
        ];

        // الاستعلام الأساسي مع العلاقات
        $query = PropertyRequest::with(['unitType', 'customer', 'matchedUnit.property']);

        // فلتر البحث النصي (الاسم، رقم الجوال، الهوية، الملاحظات)
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('client_name', 'like', "%{$search}%")
                  ->orWhere('client_phone', 'like', "%{$search}%")
                  ->orWhere('national_id', 'like', "%{$search}%")
                  ->orWhere('district', 'like', "%{$search}%")
                  ->orWhere('notes', 'like', "%{$search}%");
            });
        }

        // فلتر الحالة
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // فلتر نوع العقار المطلوب
        if ($request->filled('unit_type_id') && $request->unit_type_id !== 'all') {
            $query->where('unit_type_id', $request->unit_type_id);
        }

        // فلتر نوع الطلب (إيجار / بيع)
        if ($request->filled('request_type') && $request->request_type !== 'all') {
            $query->where('request_type', $request->request_type);
        }

        // فلتر المدينة
        if ($request->filled('city') && $request->city !== 'all') {
            $query->where('city', $request->city);
        }

        // الترتيب: الأحدث أولاً
        $requests = $query->latest()->paginate(15)->appends($request->query());

        // البيانات اللازمة للفلاتر
        $unitTypes = UnitType::all();
        $cities = Property::whereNotNull('city')->distinct()->pluck('city');

        return view('property_requests.index', compact('requests', 'stats', 'unitTypes', 'cities'));
    }

    /**
     * صفحة تسجيل طلب عقار جديد
     */
    public function create()
    {
        $unitTypes = UnitType::all();
        $customers = customers::select('id', 'name', 'phone', 'email', 'id_number')
            ->orderBy('name')
            ->get();
        $cities = Property::whereNotNull('city')->distinct()->pluck('city');

        return view('property_requests.create', compact('unitTypes', 'customers', 'cities'));
    }

    /**
     * حفظ طلب العقار في قاعدة البيانات
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_name'       => 'required|string|max:255',
            'client_phone'      => 'required|string|max:50',
            'client_email'      => 'nullable|email|max:255',
            'national_id'       => 'nullable|string|max:50',
            'customer_id'       => 'nullable|exists:customers,id',
            'request_type'      => 'required|in:rent,sale',
            'unit_type_id'      => 'nullable|exists:unit_types,id',
            'city'              => 'nullable|string|max:100',
            'district'          => 'nullable|string|max:150',
            'min_price'         => 'nullable|numeric|min:0',
            'max_price'         => 'nullable|numeric|min:0',
            'rooms_count'       => 'nullable|integer|min:0',
            'bathrooms_count'   => 'nullable|integer|min:0',
            'floor_number'      => 'nullable|string|max:100',
            'finishing_type'    => 'nullable|string|max:100',
            'ac_status'         => 'nullable|string|max:100',
            'notes'             => 'nullable|string',
        ], [
            'client_name.required'  => 'يرجى إدخال اسم العميل.',
            'client_phone.required' => 'يرجى إدخال رقم جوال العميل.',
            'request_type.required' => 'يرجى تحديد نوع الطلب (إيجار أو شراء).',
        ]);

        $validated['status'] = 'pending';
        $validated['created_by'] = Auth::id();

        // في حال كان العميل غير مسجل في جدول العملاء، يمكن ربطه إن رغب المستخدم
        if (empty($validated['customer_id']) && $request->boolean('save_as_new_customer')) {
            $customer = customers::create([
                'name'      => $validated['client_name'],
                'phone'     => $validated['client_phone'],
                'email'     => $validated['client_email'] ?? null,
                'id_number' => $validated['national_id'] ?? null,
                'address'   => ($validated['city'] ?? '') . ' ' . ($validated['district'] ?? ''),
            ]);
            $validated['customer_id'] = $customer->id;
        }

        $propertyRequest = PropertyRequest::create($validated);

        return redirect()->route('property-requests.show', $propertyRequest->id)
            ->with('success', 'تم تسجيل طلب التسكين في قائمة الانتظار بنجاح.');
    }

    /**
     * عرض تفاصيل الطلب مع فحص ومطابقة الوحدات المتوفرة وأزرار التواصل
     */
    public function show($id)
    {
        $propertyRequest = PropertyRequest::with([
            'unitType',
            'customer',
            'matchedUnit.property',
            'matchedProperty',
            'creator'
        ])->findOrFail($id);

        // جلب الوحدات الشاغرة المتوفرة التي تطابق مواصفات هذا الطلب
        $matchingUnits = $propertyRequest->findMatchingUnits(20);

        return view('property_requests.show', compact('propertyRequest', 'matchingUnits'));
    }

    /**
     * صفحة تعديل مواصفات الطلب
     */
    public function edit($id)
    {
        $propertyRequest = PropertyRequest::findOrFail($id);
        $unitTypes = UnitType::all();
        $customers = customers::select('id', 'name', 'phone', 'email', 'id_number')
            ->orderBy('name')
            ->get();
        $cities = Property::whereNotNull('city')->distinct()->pluck('city');

        return view('property_requests.edit', compact('propertyRequest', 'unitTypes', 'customers', 'cities'));
    }

    /**
     * حفظ التعديلات على الطلب
     */
    public function update(Request $request, $id)
    {
        $propertyRequest = PropertyRequest::findOrFail($id);

        $validated = $request->validate([
            'client_name'       => 'required|string|max:255',
            'client_phone'      => 'required|string|max:50',
            'client_email'      => 'nullable|email|max:255',
            'national_id'       => 'nullable|string|max:50',
            'customer_id'       => 'nullable|exists:customers,id',
            'request_type'      => 'required|in:rent,sale',
            'unit_type_id'      => 'nullable|exists:unit_types,id',
            'city'              => 'nullable|string|max:100',
            'district'          => 'nullable|string|max:150',
            'min_price'         => 'nullable|numeric|min:0',
            'max_price'         => 'nullable|numeric|min:0',
            'rooms_count'       => 'nullable|integer|min:0',
            'bathrooms_count'   => 'nullable|integer|min:0',
            'floor_number'      => 'nullable|string|max:100',
            'finishing_type'    => 'nullable|string|max:100',
            'ac_status'         => 'nullable|string|max:100',
            'notes'             => 'nullable|string',
            'status'            => 'required|in:pending,contacted,fulfilled,cancelled',
        ]);

        $propertyRequest->update($validated);

        return redirect()->route('property-requests.show', $propertyRequest->id)
            ->with('success', 'تم تحديث بيانات الطلب بنجاح.');
    }

    /**
     * حذف الطلب
     */
    public function destroy($id)
    {
        $propertyRequest = PropertyRequest::findOrFail($id);
        $propertyRequest->delete();

        return redirect()->route('property-requests.index')
            ->with('success', 'تم حذف طلب الانتظار بنجاح.');
    }

    /**
     * تحديث حالة الطلب وتسجيل ملاحظة التواصل
     */
    public function updateStatus(Request $request, $id)
    {
        $propertyRequest = PropertyRequest::findOrFail($id);

        $request->validate([
            'status'        => 'required|in:pending,contacted,fulfilled,cancelled',
            'contact_notes' => 'nullable|string',
        ]);

        $updateData = [
            'status' => $request->status,
        ];

        if ($request->filled('contact_notes')) {
            $datePrefix = '[' . now()->format('Y-m-d H:i') . ' - ' . (Auth::user()->name ?? 'موظف') . ']: ';
            $newNote = $datePrefix . $request->contact_notes;
            $updateData['contact_notes'] = $propertyRequest->contact_notes
                ? $propertyRequest->contact_notes . "\n" . $newNote
                : $newNote;
        }

        if ($request->status === 'contacted') {
            $updateData['last_contacted_at'] = now();
        }

        $propertyRequest->update($updateData);

        return redirect()->back()->with('success', 'تم تحديث حالة الطلب بنجاح.');
    }

    /**
     * تأكيد توفير العقار وتسكين العميل على وحدة معينة
     */
    public function fulfill(Request $request, $id)
    {
        $propertyRequest = PropertyRequest::findOrFail($id);

        $request->validate([
            'unit_id' => 'required|exists:units,id',
            'notes'   => 'nullable|string',
        ]);

        $unit = Unit::with('property')->findOrFail($request->unit_id);

        $note = '[' . now()->format('Y-m-d H:i') . ']: تم توفير الوحدة رقم (' . $unit->unit_number . ') بالعقار (' . ($unit->property->name ?? '') . ')';
        if ($request->filled('notes')) {
            $note .= ' - ' . $request->notes;
        }

        $propertyRequest->update([
            'status'              => 'fulfilled',
            'matched_unit_id'     => $unit->id,
            'matched_property_id' => $unit->property_id,
            'last_contacted_at'   => now(),
            'contact_notes'       => $propertyRequest->contact_notes
                ? $propertyRequest->contact_notes . "\n" . $note
                : $note,
        ]);

        return redirect()->back()->with('success', 'تم ربط الطلب بالوحدة بنجاح وتغيير حالته إلى (تم التسكين).');
    }
}
