<?php
namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\PropertyImage;
use App\Models\Owner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PropertyController extends Controller
{
    public function defaultControl()
{
    // جلب أول عقار مسجل في قاعدة البيانات
    $property = Property::first();

    // إذا لم يكن هناك أي عقار مسجل، يتم توجيهه لصفحة إنشاء عقار جديد أو قائمة العقارات
    if (!$property) {
        return redirect()->route('properties.index')->with('error', 'الرجاء إضافة عقار أولاً.');
    }

    // التوجيه إلى شاشة التحكم الخاصة بالعقار الأول مع تمرير الـ ID
    return redirect()->route('properties.control', $property->id);
}

    public function showControl($id)
{
    // جلب العقار المختار مع وحداته، وعقد الإيجار النشط، والمستأجر
    $property = Property::with(['units.activeContract.tenant'])->findOrFail($id);
    
    // جلب كافة العقارات لتظهر في القائمة المنسدلة بالأعلى للتنقل بينها
    $allProperties = Property::all();

    return view('properties.property_control', compact('property', 'allProperties'));
}


    // عرض جميع العقارات مع المالك والوحدات
    public function index()
    {
        $properties = Property::with(['owner', 'units'])->get();
        return view('properties.index', compact('properties'));
    }

    // صفحة إضافة عقار جديد
    public function create()
    {
        $owners = Owner::all();
        $properties = Property::all();
        return view('properties.create', compact('owners', 'properties'));
    }
    public function edit($id)
    {
        $property = Property::with('media')->findOrFail($id);
        $owners = Owner::all(); // أو نموذج الملاك لديك
        return view('properties.edit', compact('property', 'owners'));
    }

    public function update(Request $request, $id)
    {
        $property = Property::findOrFail($id);

        // 1. تحديث بيانات العقار الأساسية
        $property->update($request->except('media'));

        // 2. معالجة الصور الجديدة
        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $file) {
                // استخدام نفس طريقة storeAs المتبعة في دالة store
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

                // هذا السطر سيقوم بالتخزين في storage/app/public/properties_media
                $path = $file->storeAs('properties_media', $filename, 'public');

                // إنشاء سجل جديد في قاعدة البيانات
                PropertyImage::create([
                    'property_id' => $property->id,
                    'file_path' => $path // سيتم حفظ المسار بالشكل: properties_media/اسم_الملف.ext
                ]);
            }
        }
        $properties = Property::with(['owner', 'units'])->get();

        return redirect()->route('properties.index', compact('properties'))->with('success', 'تم تعديل العقار بنجاح');
    }
    // حفظ عقار جديد في القاعدة
    public function store(Request $request)
    {
        // التحقق من صحة المدخلات
        $request->validate([
            'owner_id' => 'required|exists:owners,id',
            'property_category' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'district' => 'nullable|string|max:255',

            // بيانات المالك والهوية
            'owner_id_number' => 'nullable|string|max:100',
            'owner_nationality' => 'nullable|string|max:100',
            'owner_phone' => 'nullable|string|max:100',
            'owner_landline' => 'nullable|string|max:100',
            'owner_address' => 'nullable|string|max:255',
            'owner_email' => 'nullable|email|max:255',

            // البيانات البنكية والمالية
            'bank_name' => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:100',
            'iban' => 'nullable|string|max:100',
            'commission_rate' => 'nullable|numeric',
            'insurance_account' => 'nullable|string|max:100',
            'water_account' => 'nullable|string|max:100',

            'description' => 'nullable|string',
            'media.*' => 'nullable|file|mimes:jpeg,png,jpg,gif,mp4,mov,avi|max:20480',
        ]);

        DB::beginTransaction();
        try {
            // حفظ بيانات العقار كاملة
            $property = Property::create($request->all());

            // معالجة رفع الملفات والمرفقات (صور / فيديو)
            if ($request->hasFile('media')) {
                foreach ($request->file('media') as $file) {
                    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs('properties_media', $filename, 'public');

                    PropertyImage::create([
                        'property_id' => $property->id,
                        'file_path' => $path
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('properties.index')->with('success', 'تم حفظ العقار بجميع البيانات بنجاح');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'حدث خطأ ما: ' . $e->getMessage()])->withInput();
        }
    }

    // عرض تفاصيل عقار مع وحدة محددة
    public function show($id)
    {
        $property = Property::with(['owner', 'units'])->findOrFail($id);
        return view('properties.show', compact('property'));
    }
}