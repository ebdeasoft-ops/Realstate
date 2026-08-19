<?php

namespace App\Http\Controllers;

use App\Models\PropertyExpense;
use App\Models\Property;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\CreditTransactions;
use App\Models\financial_accounts;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PropertyExpenseController extends Controller
{
    public function create()
    {
        $properties = Property::all();
        $units = Unit::all(); 
        return view('expenses.create', compact('properties', 'units'));
    }

    public function store(Request $request)
    {
        // التحقق من البيانات المدخلة
        $validated = $request->validate([
            'property_id'    => 'required|exists:properties,id',
            'unit_id'        => 'nullable|exists:units,id',
            'expense_type'   => 'required|string',
            'amount'         => 'required|numeric|min:0',
            'expense_date'   => 'required|date',
            'payment_method' => 'required|string',
            'description'    => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            // جلب الحسابات المالية
            $branchId = Auth::user()->branchs_id ?? 1;
            $financialAccountCash = financial_accounts::where('parent_account_number', 5)->where('branchs_id', $branchId)->first();
            $financialAccountBank = financial_accounts::where('parent_account_number', 4)->where('branchs_id', $branchId)->first();

            // تحديد حساب الدفع (نقدي أو تحويل بنكي)
            $payMethod = $request->payment_method; // تم توحيد الاسم بناءً على الـ Form
            $ownerId = ($payMethod == 'cash') ? optional($financialAccountCash)->id : optional($financialAccountBank)->id; 

            $property = Property::with('owner')->find($request->property_id);

            // جلب اسم الوحدة إن وجدت، وإلا فكتب "عام"
            $unitName = "عام";
            if (!empty($request->unit_id)) {
                $unit = Unit::find($request->unit_id);
                $unitName = $unit ? ($unit->name ?? $unit->unit_number) : "عام";
            }

            $noteText = "مصروفات خاصة بالعقار: " . $property->name . " - وحدة: " . $unitName . $request->description??"";

            // 1. تسجيل المعاملة في الصندوق أو البنك (دائن)
            if ($ownerId) {
                CreditTransactions::create([
                    'user_id'          => Auth::id(),
                    'customer_id'      => $ownerId,
                    'recive_amount'    => $request->amount,
                    'branchs_id'       => $branchId,
                    'pay_method'       => $payMethod,
                    'note'             => $noteText,
                    'currentblance'    => 0,
                    'Pay_Method_Name'  => $payMethod,
                    'creditor'         => $request->amount,
                    'created_at'       => Carbon::now('Asia/Riyadh'),
                    'updated_at'       => Carbon::now('Asia/Riyadh'),
                ]);
            }

            // 2. تسجيل المعاملة على حساب مالك العقار (مدين)
            if ($property && $property->owner) {
                $customerAccount = financial_accounts::where('orginal_type', 2)->where('orginal_id', $property->owner->id)->first();
                
                if ($customerAccount) {
                    CreditTransactions::create([
                        'user_id'          => Auth::id(),
                        'customer_id'      => $customerAccount->id,
                        'recive_amount'    => $request->amount,
                        'branchs_id'       => $branchId,
                        'pay_method'       => $payMethod,
                        'note'             => $noteText,
                        'currentblance'    => 0,
                        'Pay_Method_Name'  => $payMethod,
                        'debtor'           => $request->amount,
                        'created_at'       => Carbon::now('Asia/Riyadh'),
                        'updated_at'       => Carbon::now('Asia/Riyadh'),
                    ]);
                }
            }

            // 3. حفظ المصروف في جدول المصروفات الرئيسي
            PropertyExpense::create([
                'property_id'    => $request->property_id,
                'unit_id'        => $request->unit_id,
                'expense_type'   => $request->expense_type,
                'amount'         => $request->amount,
                'expense_date'   => $request->expense_date,
                'payment_method' => $payMethod,
                'description'    => $request->description,
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'تم إضافة المصروف بنجاح!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'حدث خطأ أثناء الحفظ: ' . $e->getMessage()])->withInput();
        }
    }
public function netRevenueReport(Request $request)
{
    $properties = Property::all();
    $reportData = null;

    if ($request->filled('property_id') && $request->filled('from_date') && $request->filled('to_date')) {
        $propertyId = $request->property_id;
        $fromDate = $request->from_date;
        $toDate = $request->to_date;

        $property = Property::find($propertyId);
        
        // 1. جلب الأقساط المحصلة (المدفوعة) مفصلة مع بيانات الوحدة والمستأجر
        $paidInstallments = \App\Models\RentInstallment::with(['UnitData', 'tenantData'])
            ->whereHas('UnitData', function($q) use ($propertyId) {
                $q->where('property_id', $propertyId);
            })
            ->where('status', 'paid')
            ->whereDate('paid_date', '>=', $fromDate)
            ->whereDate('paid_date', '<=', $toDate)
            ->get();

        $totalRevenue = $paidInstallments->sum('amount');

        // 2. جلب المصروفات مفصلة خلال الفترة
        $expenses = PropertyExpense::where('property_id', $propertyId)
            ->whereDate('expense_date', '>=', $fromDate)
            ->whereDate('expense_date', '<=', $toDate)
            ->get();

        $totalExpenses = $expenses->sum('amount');
        
        // تفصيل المصروفات حسب النوع
        $waterExpenses = $expenses->where('expense_type', 'water')->sum('amount');
        $electricityExpenses = $expenses->where('expense_type', 'electricity')->sum('amount');
        $maintenanceExpenses = $expenses->where('expense_type', 'maintenance')->sum('amount');
        $otherExpenses = $expenses->where('expense_type', 'other')->sum('amount');

        // 3. نسبة السعي أو العمولة
        $commissionRate = $property->commission_rate ?? 2.5;
        $commissionAmount = ($totalRevenue * $commissionRate) / 100;

        // 4. صافي الإيراد النهائي
        $netRevenue = $totalRevenue - ($totalExpenses + $commissionAmount);

        $reportData = [
            'property'             => $property,
            'paid_installments'    => $paidInstallments, // قائمة الأقساط المفصلة
            'expenses'             => $expenses,         // قائمة المصروفات المفصلة
            'total_revenue'        => $totalRevenue,
            'water_expenses'       => $waterExpenses,
            'electricity_expenses' => $electricityExpenses,
            'maintenance_expenses' => $maintenanceExpenses,
            'other_expenses'       => $otherExpenses,
            'total_expenses'       => $totalExpenses,
            'commission_rate'      => $commissionRate,
            'commission_amount'    => $commissionAmount,
            'net_revenue'          => $netRevenue,
            'from_date'            => $fromDate,
            'to_date'              => $toDate,
        ];
    }

    if ($request->ajax()) {
        return response()->json([
            'html' => view('reports.partials.report_content', compact('reportData'))->render()
        ]);
    }

    return view('expenses.net_revenue', compact('properties', 'reportData'));
}


public function report(Request $request)
{
    $properties = Property::all();

    // بناء الاستعلام مع الفلاتر
    $query = PropertyExpense::with(['property', 'unit']);

    if ($request->filled('property_id')) {
        $query->where('property_id', $request->property_id);
    }
    if ($request->filled('expense_type')) {
        $query->where('expense_type', $request->expense_type);
    }
    if ($request->filled('from_date')) {
        $query->whereDate('expense_date', '>=', $request->from_date);
    }
    if ($request->filled('to_date')) {
        $query->whereDate('expense_date', '<=', $request->to_date);
    }

    $expenses = $query->latest()->get();
    $totalAmount = $expenses->sum('amount');

    // إذا كان الطلب من نوع AJAX، نرجع البيانات بصيغة JSON
    if ($request->ajax()) {
        $mappedExpenses = $expenses->map(function($expense, $index) {
            $type = 'أخرى';
            if($expense->expense_type == 'water') $type = 'ماء';
            elseif($expense->expense_type == 'electricity') $type = 'كهرباء';
            elseif($expense->expense_type == 'maintenance') $type = 'صيانة عامة';

            return [
                'index'          => $index + 1,
                'date'           => $expense->expense_date,
                'property_name'  => optional($expense->property)->name ?? '-',
                'unit_name'      => optional($expense->unit)->name ?? optional($expense->unit)->unit_number ?? 'عام',
                'type'           => $type,
                'amount'         => number_format($expense->amount, 2),
                'payment_method' => $expense->payment_method == 'cash' ? 'نقدي' : 'تحويل بنكي',
                'description'    => $expense->description ?? '-'
            ];
        });

        return response()->json([
            'expenses'    => $mappedExpenses,
            'totalAmount' => number_format($totalAmount, 2)
        ]);
    }

    // إذا كان طلب عادي (أول مرة تفتح الصفحة)، نعرض الـ View
    return view('expenses.report', compact('properties', 'expenses', 'totalAmount'));
}


}