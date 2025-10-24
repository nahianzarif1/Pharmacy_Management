<?php

namespace App\Http\Controllers;

use App\Models\PurchaseItem;
use Illuminate\Http\Request;

class PurchaseItemController extends Controller
{
    public function index()
    {
        $items = PurchaseItem::with(['purchase','medicine'])->latest()->paginate(25);
        return view('purchase_items.index', compact('items'));
    }

    public function show($id)
    {
        $item = PurchaseItem::with(['purchase','medicine'])->findOrFail($id);
        return view('purchase_items.show', compact('item'));
    }
}
