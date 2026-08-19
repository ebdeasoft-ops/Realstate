<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\financial_accounts;
use App\Models\customers;

class TenantController extends Controller
{
public function index(Request $request)
{
    // جلب كل المستأجرين لملء قائمة الـ Select الخاصة بالبحث
    $allTenants = Tenant::all();

    // بناء الاستعلام للجدول مع التقسيم (Paginate)
    $query = Tenant::query();

    // البحث عن طريق الـ Select (اختيار اسم مستأجر محدد من القائمة)
    if ($request->filled('tenant_id')) {
        $query->where('id', $request->tenant_id);
    }

    // البحث برقم الهوية (إذا تم إدخاله في خانة النص)
    if ($request->filled('search_id')) {
        $query->where('id_number', 'like', '%' . $request->search_id . '%');
    }

    // جلب النتائج مع التقسيم (مثلاً 10 مستأجرين في كل صفحة) مع الاحتفاظ بمعايير البحث في روابط الصفحات
    $tenants = $query->paginate(10)->appends($request->query());

    return view('tenants.index', compact('tenants', 'allTenants'));
}


    public function create()
    {
        return view('tenants.create');
    }

    // دالة عرض صفحة التعديل
    public function edit($id)
    {
        $tenant = customers::findOrFail($id);
        return view('tenants.edit', compact('tenant'));
    }

    // دالة حفظ التعديلات وتحديث البيانات
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
        ]);

        DB::transaction(function () use ($request, $id) {
            $tenant = customers::findOrFail($id);

            // 1. تحديث بيانات المستأجر بالأسماء الصحيحة المطابقة لقاعدة البيانات
            $tenant->update([
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'Balance' => $request->Balance ?? 0,
                'grace_period_in_days' => $request->grace_period_in_days ?? 30,
                'tax_no' => $request->tax_no ?? 0,
                'Limit_credit' => $request->Limit_credit ?? 10000,
                'address' => $request->address,
                'sub_city' => $request->sub_city,
                'street_name' => $request->street_name,
                'plot_identification' => $request->plot_identification,
                'building_number' => $request->building_number,
                'postcode' => $request->postcode,
                'notes' => $request->notes,
                'CRN' => $request->CRN,
                'id_number' => $request->id_number,       // تمت الإضافة
                'nationality' => $request->nationality,   // تمت الإضافة
            ]);

            // 2. تحديث الحساب المالي المرتبط
            $financialAccount = financial_accounts::where('orginal_id', $tenant->id)->where('orginal_type', 1)->first();
            if ($financialAccount) {
                $financialAccount->update([
                    'name' => $request->name,
                    'current_balance' => $request->Balance ?? $financialAccount->current_balance,
                    'tax_no' => $request->tax_no ?? 0,
                ]);
            }
        });

        $message = app()->getLocale() == 'ar' ? 'تم تحديث بيانات المستأجر بنجاح' : 'Tenant updated successfully';
        session()->flash('success', $message);

        return redirect()->route('tenants.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'tax_no' => 'nullable|numeric',
            'Balance' => 'nullable|numeric',
            'grace_period_in_days' => 'nullable|numeric',
            'Limit_credit' => 'nullable|numeric'
        ]);

        DB::transaction(function () use ($request) {
            // 1. إنشاء المستأجر الجديد
            $tenant = customers::create([
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'Balance' => $request->Balance ?? 0,
                'grace_period_in_days' => $request->grace_period_in_days ?? 30,
                'tax_no' => $request->tax_no ?? 0,
                'CRN' => $request->CRN ?? 0,
                'Limit_credit' => $request->Limit_credit ?? 10000,

                // إذا كان الحقل فارغاً سيتم وضع نقطة (.) مكانه
                'address' => !empty($request->city) ? $request->city : '.',
                'sub_city' => !empty($request->sub_city) ? $request->sub_city : '.',
                'street_name' => !empty($request->street_name) ? $request->street_name : '.',
                'plot_identification' => !empty($request->plot_identification) ? $request->plot_identification : '.',
                'building_number' => !empty($request->building_number) ? $request->building_number : '.',
                'postcode' => !empty($request->postcode) ? $request->postcode : '.',
                'notes' => !empty($request->notes) ? $request->notes : '.',

                'id_number' => !empty($request->id_number) ? $request->id_number : '.',       // رقم الهوية إن وجد وإلا نقطة
                'nationality' => !empty($request->nationality) ? $request->nationality : '.', // الجنسية إن وجدت وإلا نقطة
            ]);



            // 2. جلب حساب الأب الفعلي للمستأجرين (تعديل الـ ID حسب الجدول لديك)
            $parentAccount = financial_accounts::find(2); // مثال: حساب المستأجرين الرئيسي
            $parentAccountNumber = $parentAccount ? $parentAccount->account_number : 12;

            // 3. البحث عن أكبر رقم حساب فرعي لتوليد التسلسل التالي
            $maxAccountNumber = financial_accounts::where('parent_account_number', 2)
                ->max('account_number');

            if (!$maxAccountNumber) {
                $nextAccountNumber = $parentAccountNumber . '1';
            } else {
                $nextAccountNumber = $maxAccountNumber + 1;
            }

            // 4. إنشاء الحساب المالي المرتبط بالمستأجر
            financial_accounts::create([
                'name' => $request->name,
                'account_type' => 1, // نوع الحساب (مستأجرين / عملاء)
                'parent_account_number' => 2,
                'account_number' => $nextAccountNumber,
                'start_balance' => 0,
                'current_balance' => $request->Balance ?? 0,
                'start_balance_status' => 3,
                'added_by' => auth()->id() ?? 1,
                'com_code' => 1,
                'date' => Carbon::now()->addHours(3),
                'active' => 1,
                'is_parent' => 0,
                'orginal_id' => $tenant->id,
                'orginal_type' => 1, // أو النوع المخصص للمستأجرين في النظام
                'tax_no' => $request->tax_no ?? 0,
            ]);
        });

        $message = app()->getLocale() == 'ar' ? 'تم إضافة المستأجر بنجاح' : 'Tenant added successfully';
        session()->flash('success', $message);

        return redirect()->route('tenants.index');
    }

    public function show($id)
    {
        $tenant = Tenant::with('contracts.unit.property')->findOrFail($id);
        return view('tenants.show', compact('tenant'));
    }

    public function destroy($id)
    {
        $tenant = Tenant::findOrFail($id);
        $tenant->delete();

        return redirect()->route('tenants.index')->with('success', 'تم حذف المستأجر بنجاح');
    }
}