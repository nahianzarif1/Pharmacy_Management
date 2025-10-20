<?php

namespace App\Http\Controllers;

use App\Models\PharmacyReturn;
use Illuminate\Http\Request;

class ReturnController extends Controller
{
    public function index()
    {
        return response()->json(PharmacyReturn::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sale_id' => 'required|exists:sales,id',
            'medicine_id' => 'required|exists:medicines,id',
            'quantity' => 'required|integer|min:1',
            'reason' => 'nullable|string',
            'refund_amount' => 'required|numeric|min:0',
        ]);

        $return = PharmacyReturn::create($validated);
        return response()->json($return, 201);
    }

    public function show($id)
    {
        return response()->json(PharmacyReturn::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $return = PharmacyReturn::findOrFail($id);
        $return->update($request->all());
        return response()->json($return);
    }

    public function destroy($id)
    {
        PharmacyReturn::findOrFail($id)->delete();
        return response()->json(['message' => 'Return deleted successfully']);
    }
}
