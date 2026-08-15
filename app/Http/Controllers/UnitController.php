<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\Property;
use App\Models\UnitImage;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    // عرض الوحدات الخاصة بعقار معين أو كل الوحدات
    public function index()
    {
        $units = Unit::with('property')->get();
        return view('units.index', compact('units'));
    }

    public function create()
    {
        $properties = Property::all();
        return view('units.create', compact('properties'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'property_id' => 'required|exists:properties,id',
            'unit_number' => 'required|string|max:255',
            'annual_rent' => 'required|numeric',
            'status' => 'required|string',
            'electricity_meter' => 'nullable|string|max:255',
            'water_meter' => 'nullable|string|max:255',
            'ac_count' => 'nullable|integer',
            'media.*' => 'nullable|file|mimes:jpeg,png,jpg,gif,mp4,mov,avi|max:20480',
        ]);

        // حفظ بيانات الوحدة
        $unit = Unit::create($request->except('media'));

        // معالجة رفع الملفات والمرفقات للوحدة
        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $file) {
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('units_media', $filename, 'public');
                
                // حفظ مسار المرفق في جدول unit_images
                UnitImage::create([
                    'unit_id' => $unit->id, 
                    'file_path' => $path
                ]);
            }
        }

        return redirect()->route('units.index')->with('success', 'تم حفظ الوحدة بنجاح');
    }

public function edit($id)
    {
        $unit = Unit::with('images')->findOrFail($id);
        $properties = Property::all();
        return view('units.edit', compact('unit', 'properties'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'property_id' => 'required|exists:properties,id',
            'unit_number' => 'required|string|max:255',
            'annual_rent' => 'required|numeric',
            'status' => 'required|string',
            'electricity_meter' => 'nullable|string|max:255',
            'water_meter' => 'nullable|string|max:255',
            'ac_count' => 'nullable|integer',
            'media.*' => 'nullable|file|mimes:jpeg,png,jpg,gif,mp4,mov,avi|max:20480',
        ]);

        $unit = Unit::findOrFail($id);

        // تحديث بيانات الوحدة
        $unit->update($request->except('media'));

        // معالجة المرفقات الجديدة (إن وجدت)
        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $file) {
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('units_media', $filename, 'public');
                
                UnitImage::create([
                    'unit_id' => $unit->id, 
                    'file_path' => $path
                ]);
            }
        }

        return redirect()->route('units.index')->with('success', 'تم تعديل الوحدة بنجاح');
    }
    public function show($id)
    {
        // جلب الوحدة مع العقار التابع لها والمرفقات الخاصة بها
        $unit = Unit::with(['property', 'images'])->findOrFail($id);
        
        return view('units.show', compact('unit'));
    }
}