<?php


namespace App\Http\Controllers;

use App\Models\Owner;
use App\Models\financial_accounts;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OwnerController extends Controller
{
    public function index()
    {
        $owners = Owner::all();
        return view('owners.index', compact('owners'));
    }

    public function create()
    {
        return view('owners.create');
    }

public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
        ]);

      DB::transaction(function () use ($request) {
            // 1. إنشاء المالك
            $owner = Owner::create($request->all());

            // 2. جلب حساب الأب الفعلي (مثلاً الأب الخاص بالمالكين في شجرة الحسابات)
            $parentAccount = financial_accounts::find(1); // استبدل الرقم بـ ID الأب الحقيقي للمالكيين في جدولك
            $parentAccountNumber = $parentAccount ? $parentAccount->account_number : '1';

            // 3. البحث عن أكبر رقم حساب فرعي يتبع لهذا الأب
            $maxAccountNumber = financial_accounts::where('parent_account_number', 1)
                ->max('account_number');

            if (!$maxAccountNumber) {
                $nextAccountNumber = $parentAccountNumber . '1';
            } else {
                $nextAccountNumber = $maxAccountNumber + 1;
            }

            // 4. إنشاء الحساب المالي المرتبط بالمالك في شجرة الحسابات
            financial_accounts::create([
                'name' => $request->name,
                'account_type' => 2, // نوع الحساب
                'parent_account_number' => 1, 
                'account_number' => $nextAccountNumber,
                'start_balance' => 0,
                'current_balance' => 0,
                'start_balance_status' => 3,
                'added_by' => auth()->id() ?? 1,
                'com_code' => 1,
                'date' => \Carbon\Carbon::now()->addHours(3),
                'active' => 1,
                'is_parent' => 0,
                'orginal_id' => $owner->id,
                'orginal_type' => 2, // نوع الكيان (مثلاً 1 للمالكين حسب نظامك)
                'tax_no' => $request->TaxـNumber ?? '.'
            ]);
        });

        return redirect()->route('owners.index')->with('success', 'تم إضافة المالك وإضافته لشجرة الحسابات بنجاح');
    }

public function show($id)
{
    // جلب المالك مع العقارات التابعة له
    $owner = Owner::with('properties.units')->findOrFail($id);

    return view('owners.show', compact('owner'));
}
}