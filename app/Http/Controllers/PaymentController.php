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
    // ابدأ بناء الاستعلام الأساسي للأقساط مع الـ Join
    $baseQuery = DB::table('rent_installments')
        ->leftJoin('customers', 'rent_installments.tenant_id', '=', 'customers.id');

    // تطبيق فلاتر البحث والفلترة على الاستعلام
    $query = clone $baseQuery;
    $query->select('rent_installments.*', 'customers.name as tenant_name');

    if ($request->filled('tenant_id')) {
        $query->where('rent_installments.tenant_id', $request->tenant_id);
    }

    if ($request->filled('unit_id')) {
        $query->where('rent_installments.unit_id', $request->unit_id);
    }

    if ($request->filled('from_date')) {
        $query->whereDate('rent_installments.due_date', '>=', $request->from_date);
    }
    if ($request->filled('to_date')) {
        $query->whereDate('rent_installments.due_date', '<=', $request->to_date);
    }

    // جلب النتائج مع التقسيم (Paginate)
    $installments = $query->paginate(10)->appends($request->all());

    // --- حساب الإحصائيات (المربعات العلوية) مع مراعاة فلاتر البحث الحالية ---
    $statsQuery = clone $baseQuery;
    
    // إعادة تطبيق الفلاتر على استعلام الإحصائيات لتكون دقيقة ومطابقة لما يشاهده المستخدم
    if ($request->filled('tenant_id')) {
        $statsQuery->where('rent_installments.tenant_id', $request->tenant_id);
    }
    if ($request->filled('unit_id')) {
        $statsQuery->where('rent_installments.unit_id', $request->unit_id);
    }
    if ($request->filled('from_date')) {
        $statsQuery->whereDate('rent_installments.due_date', '>=', $request->from_date);
    }
    if ($request->filled('to_date')) {
        $statsQuery->whereDate('rent_installments.due_date', '<=', $request->to_date);
    }

    $today = now()->format('YYYY-MM-DD'); // أو التاريخ الحالي بصيغة مناسبة

    // 1. إجمالي المبالغ المطلوبة / المستحقة (للمتبقي أو الإجمالي الكلي)
    $totalAmount = (clone $statsQuery)->sum(DB::Raw('rent_installments.amount - rent_installments.paid_amount'));

    // 2. المحصلة (المدفوعة بالكامل أو إجمالي المدفوع)
    $totalPaid = (clone $statsQuery)->sum('rent_installments.paid_amount');

    // 3. المتأخرة (تاريخ الاستحقاق فات ولم تسدد بالكامل ولم تصبح مدفوعة)
    $totalOverdue = (clone $statsQuery)
        ->whereDate('rent_installments.due_date', '<', now())
        ->where('rent_installments.status', '!=', 'paid')
        ->sum(DB::Raw('rent_installments.amount - rent_installments.paid_amount'));

    // 4. قريبة الاستحقاق (خلال الأيام القادمة مثلاً من اليوم وحتى 5 أيام مقبلة وغير مدفوعة)
    $totalWarning = (clone $statsQuery)
        ->whereDate('rent_installments.due_date', '>=', now())
        ->whereDate('rent_installments.due_date', '<=', now()->addDays(5))
        ->where('rent_installments.status', '!=', 'paid')
        ->sum(DB::Raw('rent_installments.amount - rent_installments.paid_amount'));

    // جلب القوائم المنسدلة للبحث
    $tenants = DB::table('customers')->get(); 
    $units = DB::table('units')->get(); 

    return view('rents.installments', compact(
        'installments', 
        'tenants', 
        'units', 
        'totalOverdue', 
        'totalWarning', 
        'totalPaid', 
        'totalAmount'
    ));
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


    $financialAccount_Cach = financial_accounts::where('parent_account_number', 5)->where('branchs_id', Auth::user()->branchs_id)->first();
    $financialAccount_Bank= financial_accounts::where('parent_account_number', 4)->where('branchs_id', Auth::user()->branchs_id)->first();

    $ownerId = $request->pay_method=="cash"?$financialAccount_Cach->id:$financialAccount_Bank->id; 

    if ($ownerId) {
        CreditTransactions::create([
            'user_id' => Auth::id(),
            'customer_id' => $ownerId,
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