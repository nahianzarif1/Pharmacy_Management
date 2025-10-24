<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Edit Inventory Batch') }}</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <x-alert />

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('inventory-batches.update', $inventoryBatch) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Medicine</label>
                        <select name="medicine_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            @foreach($medicines as $m)
                                <option value="{{ $m->id }}" {{ $inventoryBatch->medicine_id == $m->id ? 'selected' : '' }}>{{ $m->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Batch No</label>
                            <input type="text" name="batch_no" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $inventoryBatch->batch_no }}" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Quantity</label>
                            <input type="number" name="quantity" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $inventoryBatch->quantity }}" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Received Date</label>
                            <input type="date" name="received_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ optional($inventoryBatch->received_date)->format('Y-m-d') }}">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Expiry Date</label>
                            <input type="date" name="expiry_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ optional($inventoryBatch->expiry_date)->format('Y-m-d') }}">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Unit Cost</label>
                            <input type="number" step="0.01" name="unit_cost" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $inventoryBatch->unit_cost }}">
                        </div>

                        <div>
                            <label class="inline-flex items-center mt-6">
                                <input type="checkbox" name="is_active" value="1" {{ $inventoryBatch->is_active ? 'checked' : '' }}> Active
                            </label>
                        </div>
                    </div>

                    <div class="mt-6 flex items-center justify-between">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Update Batch</button>
                        <a href="{{ route('inventory-batches.index') }}" class="text-gray-500">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>