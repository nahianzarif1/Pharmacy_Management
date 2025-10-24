<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medicine;
use App\Models\InventoryBatch;
use App\Models\StockMovement;

class DashboardController extends Controller
{
    public function index()
    {
        // Key metrics for dashboard
        $totalMedicines = Medicine::count();
        $totalBatches = InventoryBatch::count();

        // Low stock medicines (use the scope) - show top 10
        // Use withSum to get total quantity across batches for each medicine
        $lowStockMedicines = Medicine::lowStock()->withSum('batches', 'quantity')->take(10)->get();

        // Expiring soon batches (next 3 months)
        $expiringBatches = InventoryBatch::expiringSoon(3)->with('medicine')->orderBy('expiry_date')->take(10)->get();

        // Recent stock movements
        $recentMovements = StockMovement::with(['medicine','batch','user'])->orderByDesc('created_at')->take(10)->get();

        return view('dashboard', compact(
            'totalMedicines',
            'totalBatches',
            'lowStockMedicines',
            'expiringBatches',
            'recentMovements'
        ));
    }
}
