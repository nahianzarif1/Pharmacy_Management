<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        return response()->json(Transaction::all());
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
