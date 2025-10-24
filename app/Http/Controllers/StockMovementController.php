<?php

namespace App\Http\Controllers;

use App\Models\StockMovement;
use Illuminate\Http\Request;

class StockMovementController extends Controller
{
    public function index()
    {
        $movements = StockMovement::with(['medicine', 'batch', 'user'])->orderByDesc('created_at')->paginate(25);
        return view('stock_movements.index', compact('movements'));
    }

    public function show($id)
    {
        $movement = StockMovement::with(['medicine','batch','user'])->findOrFail($id);
        return view('stock_movements.show', compact('movement'));
    }
}
