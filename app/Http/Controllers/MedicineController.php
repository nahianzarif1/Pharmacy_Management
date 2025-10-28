<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\MedicineType;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    // Show all medicines with search and filters
    public function index(Request $request)
    {
        $query = Medicine::with('medicineType');

        // search by sku, name, generic_name
        if ($search = $request->query('q')) {
            $query->where(function($q) use ($search) {
                $q->where('sku', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%")
                  ->orWhere('generic_name', 'like', "%{$search}%");
            });
        }

        // filter by type
        if ($type = $request->query('type')) {
            $query->where('medicine_type_id', $type);
        }

        // filter by status: active, inactive
        if (($status = $request->query('status')) !== null) {
            if ($status === 'active') $query->where('is_active', true);
            if ($status === 'inactive') $query->where('is_active', false);
        }

        // low stock filter
        if ($request->boolean('low_stock')) {
            $query->whereRaw('(
                select coalesce(sum(quantity),0) from inventory_batches where inventory_batches.medicine_id = medicines.id
            ) <= medicines.reorder_level');
        }

        $medicines = $query->latest()->paginate(15)->withQueryString();

        $types = MedicineType::orderBy('name')->get();

        return view('medicines.index', compact('medicines', 'types'));
    }

    /**
     * JSON search endpoint for typeahead
     */
    public function search(Request $request)
    {
        $q = $request->query('q');
        $results = [];
        if ($q) {
            $results = Medicine::where('sku', 'like', "%{$q}%")
                ->orWhere('name', 'like', "%{$q}%")
                ->orWhere('generic_name', 'like', "%{$q}%")
                ->limit(20)
                ->get(['id','sku','name','generic_name']);
        }

        return response()->json($results);
    }

    // Show form to add new medicine
    public function create()
    {
        $medicineTypes = MedicineType::orderBy('name')->get(['id', 'name']);
        $showTypeWarning = $medicineTypes->isEmpty();
        
        return view('medicines.create', compact('medicineTypes', 'showTypeWarning'));
    }

    // Store medicine
    public function store(Request $request)
    {
            $validated = $request->validate([
                'sku' => 'required|string|max:50|unique:medicines,sku',
                'name' => 'required|string|max:255',
                'generic_name' => 'nullable|string|max:255',
                'medicine_type_id' => 'required|exists:medicine_types,id',
                'unit' => 'required|string|max:50',
                'strength' => 'nullable|string|max:50',
                'price_per_unit' => 'required|numeric|min:0',
                'reorder_level' => 'nullable|integer|min:0',
                'is_active' => 'sometimes|boolean',
            ]);

            $medicine = Medicine::create($validated);

            return redirect()->route('medicines.show', $medicine)
                             ->with('success', 'Medicine added successfully!');
        }

        // Show medicine details
        public function show(Medicine $medicine)
        {
            $medicine->load(['medicineType', 'inventoryBatches', 'stockMovements' => function($query) {
                $query->latest()->take(10);
            }]);
        
            return view('medicines.show', compact('medicine'));
        }

        // Edit form (optional, if you want)
    public function edit(Medicine $medicine)
    {
        $medicineTypes = MedicineType::orderBy('name')->get(['id', 'name']);
        return view('medicines.edit', compact('medicine', 'medicineTypes'));
    }

    // Update medicine
    public function update(Request $request, Medicine $medicine)
    {
        $validated = $request->validate([
            'sku' => 'required|string|max:50|unique:medicines,sku,' . $medicine->id,
            'name' => 'required|string|max:255',
            'generic_name' => 'nullable|string|max:255',
            'medicine_type_id' => 'required|exists:medicine_types,id',
            'unit' => 'required|string|max:50',
            'strength' => 'nullable|string|max:50',
            'price_per_unit' => 'required|numeric|min:0',
            'reorder_level' => 'nullable|integer|min:0',
            'is_active' => 'sometimes|boolean',
        ]);

        $medicine->update($validated);

        return redirect()->route('medicines.show', $medicine)
                         ->with('success', 'Medicine updated successfully!');
    }

    // Delete
    public function destroy(Medicine $medicine)
    {
        try {
            $medicine->delete();
            return redirect()->route('medicines.index')
                           ->with('success', 'Medicine deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Cannot delete this medicine. It may have related records.');
        }
    }
}
