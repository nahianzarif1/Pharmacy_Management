<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $medicine->name }}</h2>
            <div class="space-x-2">
                <a href="{{ route('medicines.edit', $medicine) }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">Edit</a>
                <a href="{{ route('inventory-batches.create', ['medicine_id' => $medicine->id]) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Add Batch</a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <x-alert />

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <h3 class="text-lg font-semibold">Details</h3>
                        <div class="mt-2">SKU: <strong>{{ $medicine->sku }}</strong></div>
                        <div>Generic: <strong>{{ $medicine->generic_name ?? '-' }}</strong></div>
                        <div>Type: <strong>{{ $medicine->medicineType->name ?? '-' }}</strong></div>
                        <div>Unit: <strong>{{ $medicine->unit }}</strong></div>
                        <div>Strength: <strong>{{ $medicine->strength ?? '-' }}</strong></div>
                        <div>Price/unit: <strong>৳{{ number_format($medicine->price_per_unit,2) }}</strong></div>
                        <div>Reorder level: <strong>{{ $medicine->reorder_level }}</strong></div>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold">Stock Summary</h3>
                        @php $total = $medicine->inventoryBatches()->sum('quantity'); @endphp
                        <div class="mt-2">Total Stock: <strong>{{ $total }}</strong></div>
                        <div class="mt-2">Active Batches: <strong>{{ $medicine->inventoryBatches()->where('is_active', true)->count() }}</strong></div>
                        <div class="mt-2">Expiring Soon: <strong>{{ $medicine->inventoryBatches()->expiringSoon()->where('quantity','>',0)->count() }}</strong></div>
                    </div>
                </div>

                <hr class="my-4">

                <h4 class="font-semibold mb-2">Batches</h4>
                <div class="space-y-3">
                    @foreach($medicine->inventoryBatches()->orderBy('expiry_date')->get() as $batch)
                        <div class="p-3 border rounded flex justify-between items-center">
                            <div>
                                <div class="font-medium">{{ $batch->batch_no }}</div>
                                <div class="text-sm text-gray-600">Qty: {{ $batch->quantity }} | Expiry: {{ $batch->expiry_date ? $batch->expiry_date->format('Y-m-d') : '-' }}</div>
                            </div>
                            <div class="space-x-2">
                                <a href="{{ route('inventory-batches.show', $batch) }}" class="text-blue-600">View</a>
                                <a href="{{ route('inventory-batches.edit', $batch) }}" class="text-indigo-600">Edit</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>