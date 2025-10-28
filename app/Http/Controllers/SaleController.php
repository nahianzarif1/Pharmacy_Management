<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\InventoryBatch;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with('items')->latest()->paginate(20);
        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        $medicines = \App\Models\Medicine::where('is_active', true)->get();
        return view('sales.create', compact('medicines'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.medicine_id' => 'required|exists:medicines,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'nullable|numeric|min:0',
            'payment_method' => 'nullable|string',
            'customer_name' => 'nullable|string|max:255',
            'discount' => 'nullable|numeric|min:0',
            'tax' => 'nullable|numeric|min:0',
        ]);

        try {
            DB::transaction(function() use ($request) {
            $sale = Sale::create([
                'invoice_no' => $request->invoice_no ?? 'INV-'.time(),
                'sold_by'=>auth()->id(),
                'customer_name'=>$request->customer_name,
                'subtotal'=>0,
                'discount'=>$request->discount ?? 0,
                'tax'=>$request->tax ?? 0,
                'total'=>0,
                'payment_method'=>$request->payment_method,
            ]);

            $subtotal = 0;
            foreach($request->items as $it) {
                // expected: medicine_id, quantity
                $medicineId = $it['medicine_id'];
                $qtyNeeded = (int)$it['quantity'];
                $unitPrice = $it['unit_price'] ?? \App\Models\Medicine::find($medicineId)->price_per_unit;

                // find batches ordered by earliest expiry then earliest received (FIFO by expiry)
                $batches = InventoryBatch::where('medicine_id',$medicineId)
                            ->where('quantity','>',0)
                            ->orderBy('expiry_date','asc')
                            ->orderBy('received_date','asc')
                            ->get();

                foreach($batches as $batch) {
                    if($qtyNeeded <= 0) break;
                    $take = min($batch->quantity, $qtyNeeded);

                    // create sale item
                    $lineTotal = $take * $unitPrice;
                    SaleItem::create([
                        'sale_id'=>$sale->id,
                        'medicine_id'=>$medicineId,
                        'batch_id'=>$batch->id,
                        'quantity'=>$take,
                        'unit_price'=>$unitPrice,
                    ]);

                    // reduce batch
                    $batch->quantity -= $take;
                    $batch->save();

                    // log stock movement
                    StockMovement::create([
                        'medicine_id'=>$medicineId,
                        'batch_id'=>$batch->id,
                        'stock_change'=> -$take,
                        'movement_type'=>'sale',
                        'created_by'=>auth()->id(),
                        'created_at'=>now(),
                    ]);

                    $qtyNeeded -= $take;
                    $subtotal += $lineTotal;
                }

                if($qtyNeeded > 0) {
                    // insufficient stock — throw to rollback
                    throw new \Exception("Insufficient stock for medicine {$medicineId}");
                }
            }

            $sale->subtotal = $subtotal;
            $sale->total = $subtotal - ($sale->discount ?? 0) + ($sale->tax ?? 0);
            $sale->save();

            // optionally create transaction record
            \App\Models\Transaction::create([
                'sale_id'=>$sale->id,
                'payment_method'=>$sale->payment_method,
                'amount'=>$sale->total,
                'created_by'=>auth()->id(),
            ]);
            });
        } catch (\Throwable $e) {
            return back()->withInput()->with('error', 'Failed to save sale: '.$e->getMessage());
        }

        return redirect()->route('sales.index')->with('success','Sale recorded.');
    }
}

