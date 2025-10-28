<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Batch Details') }}</h2>
            <a href="{{ route('inventory-batches.index') }}" class="text-gray-500">Back to batches</a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <x-alert />

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">{{ $inventoryBatch->medicine->name }} - {{ $inventoryBatch->batch_no }}</h3>

                <div class="grid grid-cols-1 gap-4">
                    <div>Quantity: <strong>{{ $inventoryBatch->quantity }}</strong></div>
                    <div>Received: <strong>{{ $inventoryBatch->received_date ? \Illuminate\Support\Carbon::parse($inventoryBatch->received_date)->format('Y-m-d') : '-' }}</strong></div>
                    <div>Expiry: <strong>{{ $inventoryBatch->expiry_date ? \Illuminate\Support\Carbon::parse($inventoryBatch->expiry_date)->format('Y-m-d') : '-' }}</strong></div>
                    <div>Unit Cost: <strong>৳{{ number_format($inventoryBatch->unit_cost ?? 0, 2) }}</strong></div>
                </div>

                <hr class="my-4">

                <h4 class="font-semibold mb-2">Movements</h4>
                <div class="space-y-2">
                    @forelse($inventoryBatch->movements as $mv)
                        <div class="p-2 border rounded">
                            <div>{{ $mv->created_at ? \Illuminate\Support\Carbon::parse($mv->created_at)->format('Y-m-d H:i') : '-' }} - {{ ucfirst($mv->movement_type) }} - <strong>{{ $mv->stock_change }}</strong> by {{ $mv->user->name ?? 'system' }}</div>
                        </div>
                    @empty
                        <div class="text-gray-500">No movements yet.</div>
                    @endforelse
                </div>

                <hr class="my-4">

                <h4 class="font-semibold mb-2">Adjust Stock</h4>
                <form method="POST" action="{{ route('inventory-batches.adjust', $inventoryBatch) }}">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Change (use negative to reduce)</label>
                            <input type="number" name="change" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Reason</label>
                            <input type="text" name="reason" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">Adjust</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>