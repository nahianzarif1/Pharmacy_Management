<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pharmacy Management</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-800 antialiased">
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div class="flex items-center space-x-4">
                    <div class="text-2xl font-bold text-green-700">Pharmacy<span class="text-gray-700">Mgmt</span></div>
                    <div class="text-sm text-gray-500">Inventory & Sales</div>
                </div>

                <nav class="space-x-3">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Login</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">Register</a>
                            @endif
                        @endauth
                    @endif
                </nav>
            </div>
        </div>
    </header>

    <main class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="p-8 grid grid-cols-1 lg:grid-cols-3 gap-8 items-center">
                    <div class="lg:col-span-2">
                        <h1 class="text-3xl font-bold text-gray-900">Powerful pharmacy management, simplified.</h1>
                        <p class="mt-4 text-gray-600 leading-relaxed">Manage medicines, suppliers, purchases and sales from a single intuitive interface. Track batches, expiry dates and stock movements to prevent stock-outs and wastage.</p>

                        <div class="mt-6 flex flex-wrap gap-3">
                            <a href="{{ route('medicines.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Medicines</a>
                            <a href="{{ route('inventory-batches.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-yellow-600 text-white rounded hover:bg-yellow-700">Inventory</a>
                            <a href="{{ route('medicine-types.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Types</a>
                        </div>
                    </div>

                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-sm font-semibold text-gray-600">Quick stats</h3>
                        <div class="mt-4 grid grid-cols-2 gap-4">
                            @php
                                use App\Models\Medicine; use App\Models\Supplier; use App\Models\Purchase; use App\Models\Sale;
                                $medCount = Medicine::count();
                                $supCount = Supplier::count();
                                $purchaseCount = Purchase::count();
                                $saleCount = Sale::count();
                            @endphp

                            <div class="bg-white p-3 rounded shadow-sm">
                                <div class="text-xs text-gray-500">Medicines</div>
                                <div class="text-xl font-bold">{{ $medCount }}</div>
                            </div>

                            <div class="bg-white p-3 rounded shadow-sm">
                                <div class="text-xs text-gray-500">Suppliers</div>
                                <div class="text-xl font-bold">{{ $supCount }}</div>
                            </div>

                            <div class="bg-white p-3 rounded shadow-sm">
                                <div class="text-xs text-gray-500">Purchases</div>
                                <div class="text-xl font-bold">{{ $purchaseCount }}</div>
                            </div>

                            <div class="bg-white p-3 rounded shadow-sm">
                                <div class="text-xs text-gray-500">Sales</div>
                                <div class="text-xl font-bold">{{ $saleCount }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold">Inventory Health</h3>
                    <p class="mt-2 text-sm text-gray-600">Track low stock and expiry alerts to reduce losses.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold">Sales & Reports</h3>
                    <p class="mt-2 text-sm text-gray-600">Generate sales reports and daily summaries for quick decisions.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold">Easy Setup</h3>
                    <p class="mt-2 text-sm text-gray-600">Configure business settings and user roles to match your pharmacy workflow.</p>
                </div>
            </div>
        </div>
    </main>

    <footer class="bg-white border-t mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 text-sm text-gray-500">
            &copy; {{ date('Y') }} Pharmacy Management. All rights reserved.
        </div>
    </footer>
</body>
</html>
