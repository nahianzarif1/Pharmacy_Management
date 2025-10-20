<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\InventoryBatch;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    public function index()
    {
        $purchases = Purchase::with('supplier')->latest()->paginate(20);
        return view('purchases.index', compact('purchases'));
    }

    public function create()
    {
        $suppliers = \App\Models\Supplier::all();
        $medicines = \App\Models\Medicine::all();
        return view('purchases.create', compact('suppliers','medicines'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'supplier_id'=>'required|exists:suppliers,id',
            'invoice_no'=>'required|unique:purchases,invoice_no',
            'items'=>'required|array',
        ]);

        DB::transaction(function() use ($request) {
            $purchase = Purchase::create([
                'supplier_id'=>$request->supplier_id,
                'invoice_no'=>$request->invoice_no,
                'purchase_date'=>$request->purchase_date ?? now(),
                'created_by'=>auth()->id(),
                'total_amount'=>0,
            ]);

            $total = 0;
            foreach($request->items as $it) {
                // expected: medicine_id, batch_no, quantity, unit_cost
                $lineTotal = $it['quantity'] * $it['unit_cost'];
                $pi = PurchaseItem::create([
                    'purchase_id'=>$purchase->id,
                    'medicine_id'=>$it['medicine_id'],
                    'batch_no'=>$it['batch_no'] ?? null,
                    'quantity'=>$it['quantity'],
                    'unit_cost'=>$it['unit_cost'],
                ]);

                $total += $lineTotal;

                // find or create inventory batch
                $batch = InventoryBatch::firstOrCreate(
                    [
                        'medicine_id'=>$it['medicine_id'],
                        'batch_no'=>$it['batch_no'] ?? 'default',
                    ],
                    [
                        'quantity'=>0,
                        'received_date'=>$it['received_date'] ?? now(),
                        'expiry_date'=>$it['expiry_date'] ?? null,
                        'unit_cost'=>$it['unit_cost'],
                        'is_active'=>true,
                    ]
                );

                // increase batch quantity
                $batch->quantity += $it['quantity'];
                $batch->save();

                // log stock movement
                StockMovement::create([
                    'medicine_id'=>$it['medicine_id'],
                    'batch_id'=>$batch->id,
                    'change'=>$it['quantity'],
                    'movement_type'=>'purchase',
                    'created_by'=>auth()->id(),
                    'created_at'=>now(),
                ]);
            }

            $purchase->total_amount = $total;
            $purchase->save();
        });

        return redirect()->route('purchases.index')->with('success','Purchase recorded.');
    }
}
