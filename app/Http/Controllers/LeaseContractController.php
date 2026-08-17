<?php
namespace App\Http\Controllers;

use App\Models\LeaseContract;
use App\Models\Unit;
use App\Models\customers;
use App\Models\CreditTransactions;
use App\Models\financial_accounts;
use App\Models\RentInstallment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Carbon\Carbon;

class LeaseContractController extends Controller
{
    public function publicShow($contract)
{
        $contract = LeaseContract::with(['unit.property', 'tenant'])->findOrFail($contract);
        return view('lease_contracts.show', compact('contract'));
}


    public function index()
    {
        $contracts = LeaseContract::with(['unit.property', 'tenant'])->get();
        return view('lease_contracts.index', compact('contracts'));
    }

    public function create()
    {
        // جلب الوحدات الشاغرة فقط والعملاء (المستأجرين)
        $units = Unit::where('is_rented', 0)->get();
        $customers = customers::all();
        return view('lease_contracts.create', compact('units', 'customers'));
    }

    public function store(Request $request)
    {$request->validate([
            'unit_id' => 'required|exists:units,id',
            'tenant_id' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'rent_amount' => 'required|numeric',
        ]);

        DB::transaction(function () use ($request) {
            // 3. حساب مدة العقد وتوليد الأقساط أولاً لنعرف الإجمالي بدقة
            $startDate = Carbon::parse($request->start_date);
            $endDate = Carbon::parse($request->end_date);
            
            $totalMonths = $startDate->diffInMonths($endDate);
            $paymentEvery = (int) ($request->payment_every ?? 6);
            $installmentsCount = ceil($totalMonths / ($paymentEvery > 0 ? $paymentEvery : 6));

            // تحديد ما إذا كان rent_amount المدخل يمثل (القسط الواحد / أو القيمة السنوية) أم (إجمالي العقد)
            // إذا كنت تريد أن يكون rent_amount هو إجمالي العقد، أو إذا أردت ضربه في عدد السنوات:
            // سنفترض هنا أن المبلغ المدخل هو قيمة الإيجار للفترة المحددة أو الكلية، ولتجنب الضرب الخاطئ نعتمد حساب الأقساط:
            $installmentAmount = $request->installment_amount > 0 
                ? $request->installment_amount 
                : ($request->rent_amount / ($installmentsCount > 0 ? $installmentsCount : 1));

            // إجمالي قيمة العقد الكلي الفعلي بناءً على عدد الأقساط ومبلغ القسط الواحد
            $totalContractAmount = $installmentAmount * $installmentsCount;

            // 1. حفظ العقد
            $contract = LeaseContract::create([
                'unit_id' => $request->unit_id,
                'tenant_id' => $request->tenant_id,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'rent_amount' => $totalContractAmount, // حفظ الإجمالي الصحيح بدلاً من القيمة المضاعفة خطأً
                
                // الحقول النصية
                'contract_number' => !empty($request->contract_number) ? $request->contract_number : '.',
                'contract_type' => !empty($request->contract_type) ? $request->contract_type : '.',
                'electricity_meter' => !empty($request->electricity_meter) ? $request->electricity_meter : '.',
                'represented_by' => !empty($request->represented_by) ? $request->represented_by : '.',
                'guarantor_name' => !empty($request->guarantor_name) ? $request->guarantor_name : '.',
                'guarantor_phone' => !empty($request->guarantor_phone) ? $request->guarantor_phone : '.',
                'notes' => !empty($request->notes) ? $request->notes : '.',

                // الحقول التاريخية والمالية
                'contract_date' => !empty($request->contract_date) ? $request->contract_date : now(),
                'payment_every' => $paymentEvery,
                'installment_amount' => $installmentAmount,
                'insurance_amount' => $request->insurance_amount ?? 0,
                'commission' => $request->commission ?? 0,
                'annual_commission' => $request->annual_commission ?? 0,
                'water_bill' => $request->water_bill ?? 0,
                'paid_amount' => $request->paid_amount ?? 0,
                'status' => 1,
            ]);

            // 2. تحديث حالة الوحدة إلى "مؤجرة"
            $unit = Unit::findOrFail($request->unit_id);
            $unit->update(['is_rented' => 1]); 

            // تكرار إنشاء الأقساط في جدول rent_installments
            for ($i = 1; $i <= $installmentsCount; $i++) {
                $dueDate = $startDate->copy()->addMonths($paymentEvery * ($i - 1));

                RentInstallment::create([
                    'contract_id'        => $contract->id,
                    'unit_id'            => $request->unit_id,
                    'tenant_id'          => $request->tenant_id,
                    'installment_number' => $i,
                    'amount'             => $installmentAmount,
                    'due_date'           => $dueDate->format('Y-m-d'),
                    'status'             => 'unpaid',
                ]);
            }

            // 4. تسجيل المعاملة المالية للمستأجر (مدين) بالإجمالي الصحيح
            $customerAccount = financial_accounts::where('orginal_type', 1)->where('orginal_id', $request->tenant_id)->first();
            if ($customerAccount) {
                CreditTransactions::create([
                    'user_id' => Auth::id(),
                    'customer_id' => $customerAccount->id,
                    'recive_amount' => $totalContractAmount,
                    'branchs_id' => Auth::user()->branchs_id ?? 1,
                    'pay_method' => $request->payment_type ?? 1,
                    'note' => 'عقد ايجار رقم :' . $contract->id,
                    'currentblance' => 0,
                    'Pay_Method_Name' => "Credit",
                    'created_at' => Carbon::now('Asia/Riyadh'),
                    'updated_at' => Carbon::now('Asia/Riyadh'),
                    'debtor' => $totalContractAmount,
                ]);
            }

            // 5. تسجيل المعاملة المالية للمالك (دائن) بالإجمالي الصحيح
            $property = $unit->property; 
            $ownerId = $property->owner_id ?? $request->owner_id; 

            $onwerAccount = financial_accounts::where('orginal_type', 2)->where('orginal_id', $ownerId)->first();
            if ($onwerAccount) {
                CreditTransactions::create([
                    'user_id' => Auth::id(),
                    'customer_id' => $onwerAccount->id,
                    'recive_amount' => $totalContractAmount,
                    'branchs_id' => Auth::user()->branchs_id ?? 1,
                    'pay_method' => $request->payment_type ?? 1,
                    'note' => 'عقد ايجار رقم :' . $contract->id,
                    'currentblance' => 0,
                    'Pay_Method_Name' => "Credit",
                    'created_at' => Carbon::now('Asia/Riyadh'),
                    'updated_at' => Carbon::now('Asia/Riyadh'),
                    'creditor' => $totalContractAmount,
                ]);
            }
        });

        return redirect()->route('lease_contracts.index')->with('success', 'تم إنشاء العقد وتوليد الأقساط بنجاح وتحديث حالة الوحدة');
        
        }

    public function show($id)
    {
        $contract = LeaseContract::with(['unit.property', 'tenant'])->findOrFail($id);
        return view('lease_contracts.show', compact('contract'));
    }

    public function edit($id)
    {
        $contract = LeaseContract::findOrFail($id);
        $units = Unit::all();
        $customers = customers::all();
        
        return view('lease_contracts.edit', compact('contract', 'units', 'customers'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'unit_id' => 'required|exists:units,id',
            'tenant_id' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'rent_amount' => 'required|numeric',
        ]);

        $contract = LeaseContract::findOrFail($id);

        DB::transaction(function () use ($request, $contract) {
            // 1. تحديث بيانات العقد
            $contract->update([
                'unit_id' => $request->unit_id,
                'tenant_id' => $request->tenant_id,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'rent_amount' => $request->rent_amount,
                'contract_number' => $request->contract_number ?? '.',
                'contract_type' => $request->contract_type ?? '.',
                'electricity_meter' => $request->electricity_meter ?? '.',
                'represented_by' => $request->represented_by ?? '.',
                'guarantor_name' => $request->guarantor_name ?? '.',
                'guarantor_phone' => $request->guarantor_phone ?? '.',
                'notes' => $request->notes ?? '.',
                'contract_date' => $request->contract_date ?? $contract->contract_date,
                'payment_every' => $request->payment_every ?? 6,
                'installment_amount' => $request->installment_amount ?? 0,
                'insurance_amount' => $request->insurance_amount ?? 0,
                'commission' => $request->commission ?? 0,
                'annual_commission' => $request->annual_commission ?? 0,
                'water_bill' => $request->water_bill ?? 0,
                'paid_amount' => $request->paid_amount ?? 0,
            ]);

            // 2. مسح الأقساط القديمة بالكامل المرتبطة بهذا العقد قبل إعادة التوليد
            RentInstallment::where('contract_id', $contract->id)->delete();

            // 3. إعادة توليد الأقساط الجديدة بناءً على المدة وطريقة الدفع المحدثة
            $startDate = Carbon::parse($request->start_date);
            $endDate = Carbon::parse($request->end_date);
            
            $totalMonths = $startDate->diffInMonths($endDate);
            $paymentEvery = (int) ($request->payment_every ?? 6);
            $installmentsCount = ceil($totalMonths / $paymentEvery);
            
            $installmentAmount = $request->installment_amount > 0 
                ? $request->installment_amount 
                : ($request->rent_amount / ($installmentsCount > 0 ? $installmentsCount : 1));

            for ($i = 1; $i <= $installmentsCount; $i++) {
                $dueDate = $startDate->copy()->addMonths($paymentEvery * ($i - 1));

                RentInstallment::create([
                    'contract_id'        => $contract->id,
                    'unit_id'            => $request->unit_id,
                    'tenant_id'          => $request->tenant_id,
                    'installment_number' => $i,
                    'amount'             => $installmentAmount,
                    'due_date'           => $dueDate->format('Y-m-d'),
                    'status'             => 'unpaid',
                ]);
            }
        });

        return redirect()->route('lease_contracts.index')->with('success', 'تم تحديث العقد وإعادة توليد الأقساط بنجاح');
    }
}