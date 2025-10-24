<?php

namespace App\Http\Controllers;

use App\Models\SaleItem;
use Illuminate\Http\Request;

class SaleItemController extends Controller
{
    public function index()
    {
        $items = SaleItem::with(['sale','medicine'])->latest()->paginate(25);
        return view('sale_items.index', compact('items'));
    }

    public function show($id)
    {
        $item = SaleItem::with(['sale','medicine'])->findOrFail($id);
        return view('sale_items.show', compact('item'));
    }
}
