<?php
namespace App\Http\Controllers;

use App\Models\LeaseContract;
use App\Models\Unit;
use App\Models\customers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LeaseContractController extends Controller
{
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
    {
        $request->validate([
            'unit_id' => 'required|exists:units,id',
            'tenant_id' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'rent_amount' => 'required|numeric',
        ]);

        DB::transaction(function () use ($request) {
            // حفظ العقد مع تعبئة الحقول الفارغة بنقطة (.) أو قيم افتراضية مناسبة
            LeaseContract::create([
                'unit_id' => $request->unit_id,
                'tenant_id' => $request->tenant_id,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'rent_amount' => $request->rent_amount,
                
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
                'payment_every' => $request->payment_every ?? 6,
                'installment_amount' => $request->installment_amount ?? 0,
                'insurance_amount' => $request->insurance_amount ?? 0,
                'commission' => $request->commission ?? 0,
                'annual_commission' => $request->annual_commission ?? 0,
                'water_bill' => $request->water_bill ?? 0,
                'paid_amount' => $request->paid_amount ?? 0,
                'status' => 1,
            ]);

            // تحديث حالة الوحدة إلى "مؤجرة"
            $unit = Unit::findOrFail($request->unit_id);
            $unit->update(['is_rented' => 1]); 
        });

        return redirect()->route('lease_contracts.index')->with('success', 'تم إنشاء العقد بنجاح وتحديث حالة الوحدة');
    }

    public function show($id)
    {
        $contract = LeaseContract::with(['unit.property', 'tenant'])->findOrFail($id);
        return view('lease_contracts.show', compact('contract'));
    }

    public function edit($id)
    {
        $contract = LeaseContract::findOrFail($id);
        // جلب الوحدات المتاحة أو الحالية للعقد + العملاء
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
            // تحديث بيانات العقد
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
        });

        return redirect()->route('lease_contracts.index')->with('success', 'تم تحديث العقد بنجاح');
    }
}