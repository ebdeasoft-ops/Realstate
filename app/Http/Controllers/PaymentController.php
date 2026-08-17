<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RentInstallment; // أو جدول الحركات المالية لديك
use Illuminate\Support\Facades\DB;
use App\Models\CreditTransactions;
use App\Models\financial_accounts;
use Auth;
use Carbon\Carbon;
class PaymentController extends Controller
{
    public function update(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'due_date' => 'required|date',
        ]);

        DB::table('rent_installments')->where('id', $id)->update([
            'amount' => $request->amount,
            'due_date' => $request->due_date,
            'updated_at' => now()
        ]);

        return redirect()->back()->with('success', 'تم تعديل القسط بنجاح');
    }
    public function payInstallment(Request $request, $id)
    {
        $installment = DB::table('rent_installments')->where('id', $id)->first();

        $newPaidAmount = $installment->paid_amount + $request->paid_now;
        $status = ($newPaidAmount >= $installment->amount) ? 'paid' : 'unpaid';

        DB::table('rent_installments')->where('id', $id)->update([
            'paid_amount' => $newPaidAmount,
            'status' => $status,
            'paid_date' => now(),
            'updated_at' => now()
        ]);

        return redirect()->back()->with('success', 'تم تسديد الدفعة بنجاح');
    }
   public function index(Request $request)
{
    // ابدأ بناء الاستعلام مع جدول الأقساط وعمل Join مع جدول العملاء (تأكد أن اسم جدول العملاء لديك customers أو tenants)
    $query = DB::table('rent_installments')
        ->leftJoin('customers', 'rent_installments.tenant_id', '=', 'customers.id')
        ->select('rent_installments.*', 'customers.name as tenant_name');

    // تصفية حسب المستأجر إذا تم اختياره
    if ($request->filled('tenant_id')) {
        $query->where('rent_installments.tenant_id', $request->tenant_id);
    }

    // تصفية حسب الوحدة إذا تم اختيارها
    if ($request->filled('unit_id')) {
        $query->where('rent_installments.unit_id', $request->unit_id);
    }

    // تصفية حسب تاريخ الاستحقاق من وإلى
    if ($request->filled('from_date')) {
        $query->whereDate('rent_installments.due_date', '>=', $request->from_date);
    }
    if ($request->filled('to_date')) {
        $query->whereDate('rent_installments.due_date', '<=', $request->to_date);
    }

    $installments = $query->get();

    // جلب القوائم المنسدلة للبحث
    $tenants = DB::table('customers')->get(); // أو جدول المستأجرين لديك
    $units = DB::table('units')->get(); // أو جدول الوحدات لديك

    return view('rents.installments', compact('installments', 'tenants', 'units'));
}

public function pay($id)
{
    $installment = RentInstallment::with('tenantData')->findOrFail($id);
    $remaining = $installment->amount - $installment->paid_amount;
    
    return view('rents.pay_installment', compact('installment', 'remaining'));
}
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required',
            'amount' => 'required|numeric',
            'pay_method' => 'required',
            'date' => 'required|date',
        ]);

        // حفظ البيانات في الجدول المناسب حسب الهيكل لديك (مثل credittransactions أو الحركات المالية)
        // Credittransaction::create([...]);

        return redirect()->back()->with('success', 'تم حفظ الدفعة بنجاح');
    }

   public function storePayment(Request $request)
{
    $request->validate([
        'installment_id' => 'required|exists:rent_installments,id',
        'amount' => 'required|numeric|min:0.01',
        'pay_method' => 'required', // طريقة الدفع القادمة من الفورم
        'date' => 'required|date',         // تاريخ الدفع القادم من الفورم
    ]);

    // جلب القسط المراد سداده
    $installment = RentInstallment::findOrFail($request->installment_id);
    
    // حساب المتبقي للتأكد من عدم تجاوز المبلغ
    $remaining = $installment->amount - $installment->paid_amount;
    
    if ($request->amount > $remaining) {
        return back()->withErrors(['amount' => 'المبلغ المدفوع أكبر من المبلغ المتبقي للقسط.']);
    }

    // تحديث المبلغ المدفوع والحالة وطريقة الدفع وتاريخ السداد
    $newPaidAmount = $installment->paid_amount + $request->amount;
    $status = ($newPaidAmount >= $installment->amount) ? 'paid' : 'partially_paid';

    $installment->update([
        'paid_amount' => $newPaidAmount,
        'status'      => $status,
        'paid_date'   => $request->date,       // تم تفعيل حفظ التاريخ القادم من الفورم هنا
        'PaymentType' => $request->pay_method, // تخزين طريقة الدفع في العمود الصحيح
    ]);

    // 4. تسجيل المعاملة المالية للمستأجر (مدين)
    $customerAccount = financial_accounts::where('orginal_type', 1)->where('orginal_id', $installment->tenant_id)->first();
    if ($customerAccount) {
        CreditTransactions::create([
            'user_id' => Auth::id(),
            'customer_id' => $customerAccount->id,
            'recive_amount' => $request->amount,
            'branchs_id' => Auth::user()->branchs_id ?? 1,
            'pay_method' => $request->pay_method ?? 1,
            'note' => 'تسديد قسط رقم :' . $installment->id . "عقد رقم " . $installment->contract_id,
            'currentblance' => 0,
            'Pay_Method_Name' => $request->pay_method,
            'created_at' => Carbon::now('Asia/Riyadh'),
            'updated_at' => Carbon::now('Asia/Riyadh'),
            'creditor' => $request->amount,
        ]);
    }

    // 5. تسجيل المعاملة المالية للمالك (دائن)
    // تأكد من جلب الوحدة والعقار بالطريقة المناسبة لديك، مثلاً عبر علاقة القسط أو العقد بالوحدة
    // $unit = ...; // تأكد من تعريف المتغير $unit إذا لم يكن معرفاً سابقاً في الدالة
    // $property = $unit->property ?? null;
    // $ownerId = $property->owner_id ?? $request->owner_id; 

    // كمثال افتراضي لجلب المالك إذا كان مرتبطاً بالعقد أو الوحدة مباشرة:
    $ownerId = $installment->UnitData->property->owner->id ?? $request->owner_id; 

    $onwerAccount = financial_accounts::where('orginal_type', 2)->where('orginal_id', $ownerId)->first();
    if ($onwerAccount) {
        CreditTransactions::create([
            'user_id' => Auth::id(),
            'customer_id' => $onwerAccount->id,
            'recive_amount' => $request->amount,
            'branchs_id' => Auth::user()->branchs_id ?? 1,
            'pay_method' => $request->pay_method ?? 1,
            'note' => 'تسديد قسط رقم :' . $installment->id . "عقد رقم " . $installment->contract_id,
            'currentblance' => 0,
            'Pay_Method_Name' => $request->pay_method,
            'created_at' => Carbon::now('Asia/Riyadh'),
            'updated_at' => Carbon::now('Asia/Riyadh'),
            'debtor' => $request->amount,
        ]);
    }

    return redirect()->route('installments.index')->with('success', 'تم سداد القسط وتخزين بيانات الدفع بنجاح');
}
}