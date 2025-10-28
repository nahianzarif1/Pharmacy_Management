<?php

namespace App\Http\Controllers;

use App\Models\InventoryBatch;
use App\Models\Medicine;
use App\Models\StockMovement;
use Illuminate\Http\Request;

class InventoryBatchController extends Controller
{
    public function index()
    {
        $batches = InventoryBatch::with('medicine')->latest()->paginate(20);
        return view('inventory-batches.index', compact('batches'));
    }

    public function create(Request $request)
    {
        $medicines = Medicine::orderBy('name')->get();
        $selectedMedicine = null;
        if ($request->has('medicine_id')) {
            $selectedMedicine = Medicine::find($request->medicine_id);
        }
        return view('inventory-batches.create', compact('medicines', 'selectedMedicine'));
    }

    public function store(Request $request)
    {
        // If frontend didn't set medicine_id, allow medicine_search and try to resolve it
        if (!$request->filled('medicine_id') && $request->filled('medicine_search')) {
            $search = $request->input('medicine_search');
            $found = Medicine::where('sku', $search)->orWhere('name', 'like', "%{$search}%")->first();
            if ($found) {
                $request->merge(['medicine_id' => $found->id]);
            }
        }

        $validated = $request->validate([
            'medicine_id' => 'required|exists:medicines,id',
            'batch_no' => 'required|string|max:50',
            'quantity' => 'required|integer|min:0',
            'received_date' => 'nullable|date',
            'expiry_date' => 'nullable|date',
            'unit_cost' => 'nullable|numeric|min:0',
        ]);

        // ensure unique per medicine_id + batch_no
        $exists = InventoryBatch::where('medicine_id', $validated['medicine_id'])
            ->where('batch_no', $validated['batch_no'])
            ->first();

        if ($exists) {
            // if exists, increase quantity and update cost/expiry if provided
            $exists->quantity += $validated['quantity'];
            if (!empty($validated['unit_cost'])) $exists->unit_cost = $validated['unit_cost'];
            if (!empty($validated['expiry_date'])) $exists->expiry_date = $validated['expiry_date'];
            $exists->save();

            $batch = $exists;
        } else {
            $batch = InventoryBatch::create($validated + ['is_active' => true]);
        }

        // create stock movement
        StockMovement::create([
            'medicine_id' => $batch->medicine_id,
            'batch_id' => $batch->id,
            'stock_change' => $validated['quantity'],
            'movement_type' => 'purchase',
            'created_by' => auth()->id(),
            'created_at' => now(),
        ]);

        return redirect()->route('inventory-batches.index')
            ->with('success', 'Inventory batch saved successfully.');
    }

    public function show(InventoryBatch $inventoryBatch)
    {
        $inventoryBatch->load('medicine', 'movements.user');
        return view('inventory-batches.show', compact('inventoryBatch'));
    }

    public function edit(InventoryBatch $inventoryBatch)
    {
        $medicines = Medicine::orderBy('name')->get();
        return view('inventory-batches.edit', compact('inventoryBatch', 'medicines'));
    }

    public function update(Request $request, InventoryBatch $inventoryBatch)
    {
        $validated = $request->validate([
            'medicine_id' => 'required|exists:medicines,id',
            'batch_no' => 'required|string|max:50',
            'quantity' => 'required|integer|min:0',
            'received_date' => 'nullable|date',
            'expiry_date' => 'nullable|date',
            'unit_cost' => 'nullable|numeric|min:0',
            'is_active' => 'boolean',
        ]);

        $inventoryBatch->update($validated);

        return redirect()->route('inventory-batches.index')
            ->with('success', 'Inventory batch updated successfully.');
    }

    public function destroy(InventoryBatch $inventoryBatch)
    {
        // do not delete if there are movements
        if ($inventoryBatch->movements()->exists()) {
            return redirect()->route('inventory-batches.index')
                ->with('error', 'Cannot delete: batch has stock movements.');
        }

        $inventoryBatch->delete();

        return redirect()->route('inventory-batches.index')
            ->with('success', 'Inventory batch deleted.');
    }

    // Adjust stock manually (increase or decrease)
    public function adjust(Request $request, InventoryBatch $inventoryBatch)
    {
        $validated = $request->validate([
            'change' => 'required|integer', // keep request param name for compatibility
            'reason' => 'nullable|string',
        ]);

        $inventoryBatch->quantity += $validated['change'];
        $inventoryBatch->save();

        StockMovement::create([
            'medicine_id' => $inventoryBatch->medicine_id,
            'batch_id' => $inventoryBatch->id,
            'stock_change' => $validated['change'],
            'movement_type' => 'adjustment',
            'created_by' => auth()->id(),
            'created_at' => now(),
        ]);

        return back()->with('success', 'Stock adjusted successfully.');
    }
}
