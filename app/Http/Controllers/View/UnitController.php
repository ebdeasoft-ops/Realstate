<?php
namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\Property;
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
            'is_rented' => 'required|boolean',
        ]);

        Unit::create($request->all());

        return redirect()->route('units.index')->with('success', 'تم إضافة الوحدة بنجاح');
    }
}