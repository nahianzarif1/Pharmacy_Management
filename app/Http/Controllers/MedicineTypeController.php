<?php

namespace App\Http\Controllers;

use App\Models\MedicineType;
use Illuminate\Http\Request;

class MedicineTypeController extends Controller
{
    public function index()
    {
        $types = MedicineType::latest()->paginate(10);
        return view('medicine-types.index', compact('types'));
    }

    public function create()
    {
        return view('medicine-types.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50|unique:medicine_types',
            'description' => 'nullable|string'
        ]);

        $medicineType = MedicineType::create($validated);

        // If this is an AJAX/JSON request, return the created model as JSON
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json($medicineType, 201);
        }

        return redirect()->route('medicine-types.index')
            ->with('success', 'Medicine type created successfully.');
    }

    public function edit(MedicineType $medicineType)
    {
        return view('medicine-types.edit', compact('medicineType'));
    }

    public function update(Request $request, MedicineType $medicineType)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50|unique:medicine_types,name,' . $medicineType->id,
            'description' => 'nullable|string'
        ]);

        $medicineType->update($validated);

        return redirect()->route('medicine-types.index')
            ->with('success', 'Medicine type updated successfully.');
    }

    public function destroy(MedicineType $medicineType)
    {
        if($medicineType->medicines()->exists()) {
            return redirect()->route('medicine-types.index')
                ->with('error', 'Cannot delete: This type has medicines associated with it.');
        }

        $medicineType->delete();

        return redirect()->route('medicine-types.index')
            ->with('success', 'Medicine type deleted successfully.');
    }
}