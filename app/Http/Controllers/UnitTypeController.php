<?php
namespace App\Http\Controllers;

use App\Models\UnitType;
use Illuminate\Http\Request;

class UnitTypeController extends Controller
{
    // عرض صفحة الإدارة والجدول
    public function index()
    {
        $unitTypes = UnitType::all();
        return view('unit_types.index', compact('unitTypes'));
    }

    // حفظ نوع وحدة جديد
    public function store(Request $request)
    {
        $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
        ]);

        UnitType::create([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
        ]);

        return redirect()->back()->with('success', __('unit_types.success_add'));
    }

    // حذف نوع الوحدة
    public function destroy($id)
    {
        $unitType = UnitType::findOrFail($id);
        
        // يمكنك إضافة تحقق إذا كانت الوحدة مستخدمة أم لا قبل الحذف
        $unitType->delete();

        return redirect()->back()->with('success', __('unit_types.success_delete'));
    }
}