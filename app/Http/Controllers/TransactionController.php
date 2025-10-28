<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $medicineId = $request->query('medicine_id');

        $query = Transaction::query()->latest();

        if (!empty($medicineId)) {
            $query->where(function ($q) use ($medicineId) {
                // Sales filter (always available via sale_items)
                $q->whereExists(function ($sub) use ($medicineId) {
                    $sub->selectRaw('1')
                        ->from('sale_items')
                        ->whereColumn('sale_items.sale_id', 'transactions.sale_id')
                        ->where('sale_items.medicine_id', $medicineId);
                });

                // Returns filter (only if returns.medicine_id exists)
                if (Schema::hasColumn('returns', 'medicine_id')) {
                    $q->orWhereExists(function ($sub) use ($medicineId) {
                        $sub->selectRaw('1')
                            ->from('returns')
                            ->whereColumn('returns.id', 'transactions.return_id')
                            ->where('returns.medicine_id', $medicineId);
                    });
                }

                // Purchases filter (only if transactions.purchase_id exists)
                if (Schema::hasColumn('transactions', 'purchase_id')) {
                    $q->orWhereExists(function ($sub) use ($medicineId) {
                        $sub->selectRaw('1')
                            ->from('purchase_items')
                            ->whereColumn('purchase_items.purchase_id', 'transactions.purchase_id')
                            ->where('purchase_items.medicine_id', $medicineId);
                    });
                }
            });
        }

        $transactions = $query->paginate(20)->appends($request->query());

        $medicines = Medicine::orderBy('name')->get(['id','name','sku']);

        return view('transactions.index', [
            'transactions' => $transactions,
            'medicines' => $medicines,
            'selectedMedicineId' => $medicineId,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'transaction_type' => 'required|string',
            'reference_id' => 'nullable|integer',
            'amount' => 'required|numeric',
            'payment_method' => 'required|string',
            'transaction_date' => 'required|date',
        ]);

        $transaction = Transaction::create($validated);
        return response()->json($transaction, 201);
    }

    public function show($id)
    {
        return response()->json(Transaction::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->update($request->all());
        return response()->json($transaction);
    }

    public function destroy($id)
    {
        Transaction::findOrFail($id)->delete();
        return response()->json(['message' => 'Transaction deleted successfully']);
    }
}
