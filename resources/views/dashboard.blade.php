<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Pharmacy Database Management') }}
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('medicines.create') }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                    New Medicine
                </a>
                <a href="{{ route('inventory-batches.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                    New Batch
                </a>
                <a href="{{ route('suppliers.create') }}" class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700">
                    New Supplier
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-white shadow rounded-lg p-4">
                    <div class="text-sm text-gray-500">Total Medicines</div>
                    <div class="mt-2 text-3xl font-bold">{{ $totalMedicines }}</div>
                    <div class="mt-4">
                        <a href="{{ route('medicines.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">View All →</a>
                    </div>
                </div>
                <div class="bg-white shadow rounded-lg p-4">
                    <div class="text-sm text-gray-500">Total Batches</div>
                    <div class="mt-2 text-3xl font-bold">{{ $totalBatches }}</div>
                    <div class="mt-4">
                        <a href="{{ route('inventory-batches.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">View All →</a>
                    </div>
                </div>
                <div class="bg-white shadow rounded-lg p-4">
                    <div class="text-sm text-gray-500">Low Stock Alerts</div>
                    <div class="mt-2 text-3xl font-bold text-red-600">{{ $lowStockMedicines->count() }}</div>
                    <div class="mt-4">
                        <a href="#low-stock" class="text-red-600 hover:text-red-800 text-sm font-medium">View Details →</a>
                    </div>
                </div>
            </div>

            <!-- Database Management Sections -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <!-- Medicine Management -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Medicine Database
                        </div>
                    </h3>
                    <div class="space-y-3">
                        <a href="{{ route('medicines.index') }}" class="block px-4 py-2 bg-gray-50 hover:bg-gray-100 rounded text-sm">
                            View All Medicines
                        </a>
                        <a href="{{ route('medicine-types.index') }}" class="block px-4 py-2 bg-gray-50 hover:bg-gray-100 rounded text-sm">
                            Medicine Types
                        </a>
                        <a href="{{ route('medicines.create') }}" class="block px-4 py-2 bg-green-50 text-green-700 hover:bg-green-100 rounded text-sm">
                            Add New Medicine
                        </a>
                    </div>
                </div>

                <!-- Inventory Management -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            Inventory Database
                        </div>
                    </h3>
                    <div class="space-y-3">
                        <a href="{{ route('inventory-batches.index') }}" class="block px-4 py-2 bg-gray-50 hover:bg-gray-100 rounded text-sm">
                            View All Batches
                        </a>
                        <a href="{{ route('stock-movements.index') }}" class="block px-4 py-2 bg-gray-50 hover:bg-gray-100 rounded text-sm">
                            Stock Movements
                        </a>
                        <a href="{{ route('inventory-batches.create') }}" class="block px-4 py-2 bg-blue-50 text-blue-700 hover:bg-blue-100 rounded text-sm">
                            Add New Batch
                        </a>
                    </div>
                </div>

                <!-- Supplier Management -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            Supplier Database
                        </div>
                    </h3>
                    <div class="space-y-3">
                        <a href="{{ route('suppliers.index') }}" class="block px-4 py-2 bg-gray-50 hover:bg-gray-100 rounded text-sm">
                            View All Suppliers
                        </a>
                        <a href="{{ route('suppliers.create') }}" class="block px-4 py-2 bg-purple-50 text-purple-700 hover:bg-purple-100 rounded text-sm">
                            Add New Supplier
                        </a>
                    </div>
                </div>
            </div>

            <!-- Transaction Management -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Purchase Management -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                            Purchase Database
                        </div>
                    </h3>
                    <div class="space-y-3">
                        <a href="{{ route('purchases.index') }}" class="block px-4 py-2 bg-gray-50 hover:bg-gray-100 rounded text-sm">
                            View All Purchases
                        </a>
                        <a href="{{ route('purchase-items.index') }}" class="block px-4 py-2 bg-gray-50 hover:bg-gray-100 rounded text-sm">
                            Purchase Items
                        </a>
                        <a href="{{ route('purchases.create') }}" class="block px-4 py-2 bg-green-50 text-green-700 hover:bg-green-100 rounded text-sm">
                            New Purchase Order
                        </a>
                    </div>
                </div>

                <!-- Sales Management -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                            </svg>
                            Sales Database
                        </div>
                    </h3>
                    <div class="space-y-3">
                        <a href="{{ route('sales.index') }}" class="block px-4 py-2 bg-gray-50 hover:bg-gray-100 rounded text-sm">
                            View All Sales
                        </a>
                        <a href="{{ route('sale-items.index') }}" class="block px-4 py-2 bg-gray-50 hover:bg-gray-100 rounded text-sm">
                            Sale Items
                        </a>
                        <a href="{{ route('sales.create') }}" class="block px-4 py-2 bg-blue-50 text-blue-700 hover:bg-blue-100 rounded text-sm">
                            New Sale
                        </a>
                    </div>
                </div>
            </div>

            <!-- Quick Actions Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <!-- Medicines Management -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        Medicines
                    </h3>
                    <div class="space-y-3">
                        <a href="{{ route('medicines.index') }}" class="block px-4 py-2 bg-gray-50 hover:bg-gray-100 rounded-md">View All Medicines</a>
                        <a href="{{ route('medicines.create') }}" class="block px-4 py-2 bg-gray-50 hover:bg-gray-100 rounded-md">Add New Medicine</a>
                        <a href="{{ route('medicine-types.index') }}" class="block px-4 py-2 bg-gray-50 hover:bg-gray-100 rounded-md">Manage Medicine Types</a>
                    </div>
                </div>

                <!-- Inventory Management -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        Inventory
                    </h3>
                    <div class="space-y-3">
                        <a href="{{ route('inventory-batches.index') }}" class="block px-4 py-2 bg-gray-50 hover:bg-gray-100 rounded-md">View All Batches</a>
                        <a href="{{ route('inventory-batches.create') }}" class="block px-4 py-2 bg-gray-50 hover:bg-gray-100 rounded-md">Add New Batch</a>
                        <button onclick="alert('Adjust Stock feature coming soon')" class="block w-full text-left px-4 py-2 bg-gray-50 hover:bg-gray-100 rounded-md">Stock Adjustment</button>
                    </div>
                </div>

                <!-- Purchase & Sales -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        Transactions
                    </h3>
                    <div class="space-y-3">
                        <button onclick="alert('New Purchase feature coming soon')" class="block w-full text-left px-4 py-2 bg-gray-50 hover:bg-gray-100 rounded-md">New Purchase</button>
                        <button onclick="alert('New Sale feature coming soon')" class="block w-full text-left px-4 py-2 bg-gray-50 hover:bg-gray-100 rounded-md">New Sale</button>
                        <button onclick="alert('View Reports feature coming soon')" class="block w-full text-left px-4 py-2 bg-gray-50 hover:bg-gray-100 rounded-md">View Reports</button>
                    </div>
                </div>
            </div>

            <!-- Data Tables -->
            <div class="grid grid-cols-1 gap-6">
                <!-- System Alerts -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4">System Alerts</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Low Stock Alert -->
                        <div class="bg-red-50 p-4 rounded-lg">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg class="w-6 h-6 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                    </svg>
                                    <span class="text-red-700 font-semibold">Low Stock</span>
                                </div>
                                <span class="text-2xl font-bold text-red-700">{{ $lowStockMedicines->count() }}</span>
                            </div>
                            <p class="mt-2 text-sm text-red-600">Items below reorder level</p>
                        </div>

                        <!-- Expiring Soon Alert -->
                        <div class="bg-yellow-50 p-4 rounded-lg">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg class="w-6 h-6 text-yellow-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="text-yellow-700 font-semibold">Expiring Soon</span>
                                </div>
                                <span class="text-2xl font-bold text-yellow-700">{{ $expiringBatches->count() }}</span>
                            </div>
                            <p class="mt-2 text-sm text-yellow-600">Batches expiring in 3 months</p>
                        </div>

                        <!-- Stock Movements -->
                        <div class="bg-green-50 p-4 rounded-lg">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg class="w-6 h-6 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                                    </svg>
                                    <span class="text-green-700 font-semibold">Stock Movements</span>
                                </div>
                                <span class="text-2xl font-bold text-green-700">{{ $recentMovements->count() }}</span>
                            </div>
                            <p class="mt-2 text-sm text-green-600">Recent inventory changes</p>
                        </div>
                    </div>
                </div>

                <!-- Recent Activities -->
                <div class="bg-white shadow rounded-lg p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Recent Database Activities</h3>
                    </div>
                    @if($recentMovements->isEmpty())
                        <div class="text-sm text-gray-500">No recent activities.</div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Timestamp</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Activity Type</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Details</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($recentMovements as $activity)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $activity->created_at ? \Illuminate\Support\Carbon::parse($activity->created_at)->format('Y-m-d H:i') : '-' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    {{ $activity->movement_type }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-900">
                                                {{ optional($activity->medicine)->name }} 
                                                <span class="text-gray-500">({{ $activity->change > 0 ? '+' : '' }}{{ $activity->change }})</span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ optional($activity->user)->name ?? 'System' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                <a href="#" class="text-blue-600 hover:text-blue-900">View Details</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
