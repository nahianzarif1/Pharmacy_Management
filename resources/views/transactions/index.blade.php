<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Transactions') }}</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-alert />

            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <div class="p-6">
                    <form method="GET" action="{{ route('transactions.index') }}" class="mb-4 flex items-center gap-3">
                        <div>
                            <label for="medicine_id" class="block text-xs font-medium text-gray-600">Medicine</label>
                            <select id="medicine_id" name="medicine_id" class="mt-1 block w-64 rounded border-gray-300">
                                <option value="">All medicines</option>
                                @foreach(($medicines ?? []) as $m)
                                    <option value="{{ $m->id }}" @selected(($selectedMedicineId ?? '') == $m->id)>
                                        {{ $m->name }} @if($m->sku) ({{ $m->sku }}) @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="pt-5 flex gap-2">
                            <button type="submit" class="px-3 py-2 border rounded">Filter</button>
                            <a href="{{ route('transactions.index') }}" class="px-3 py-2 border rounded">Reset</a>
                        </div>
                    </form>
                    @if($transactions->isEmpty())
                        <div class="text-sm text-gray-500">No transactions found.</div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Reference</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Payment</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($transactions as $t)
                                        <tr>
                                            <td class="px-6 py-4 text-sm text-gray-500">{{ $t->transaction_date ? \Illuminate\Support\Carbon::parse($t->transaction_date)->format('Y-m-d H:i') : $t->created_at?->format('Y-m-d H:i') }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-700">{{ $t->transaction_type ?? ($t->sale_id ? 'sale' : ($t->return_id ? 'return' : 'other')) }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-700">{{ $t->reference_id ?? ($t->sale_id ?? $t->return_id) }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-700">{{ $t->payment_method ?? '-' }}</td>
                                            <td class="px-6 py-4 text-sm font-medium">{{ number_format($t->amount, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">{{ $transactions->links() }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
