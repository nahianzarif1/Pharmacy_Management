<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\MedicineType;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    // Show all medicines
    public function index()
    {
        $medicines = Medicine::with('medicineType')->get();
        return view('medicines.index', compact('medicines'));
    }

    // Show form to add new medicine
    public function create()
    {
        $types = MedicineType::all();
        return view('medicines.create', compact('types'));
    }

    // Store medicine
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'type_id' => 'required|exists:medicine_types,id',
            'price' => 'required|numeric',
            'quantity' => 'required|integer|min:0',
        ]);

        Medicine::create($validated);

        return redirect()->route('medicines.index')
                         ->with('success', 'Medicine added successfully!');
    }

    // Edit form (optional, if you want)
    public function edit($id)
    {
        $medicine = Medicine::findOrFail($id);
        $types = MedicineType::all();
        return view('medicines.edit', compact('medicine', 'types'));
    }

    // Update medicine
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'type_id' => 'required|exists:medicine_types,id',
            'price' => 'required|numeric',
            'quantity' => 'required|integer|min:0',
        ]);

        $medicine = Medicine::findOrFail($id);
        $medicine->update($validated);

        return redirect()->route('medicines.index')
                         ->with('success', 'Medicine updated successfully!');
    }

    // Delete
    public function destroy($id)
    {
        $medicine = Medicine::findOrFail($id);
        $medicine->delete();

        return redirect()->route('medicines.index')
                         ->with('success', 'Medicine deleted successfully!');
    }
}
