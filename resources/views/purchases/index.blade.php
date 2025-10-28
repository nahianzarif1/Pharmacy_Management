<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Purchases') }}</h2>
            <a href="{{ route('purchases.create') }}" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded">New Purchase</a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-alert />

            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <div class="p-6">
                    @if($purchases->isEmpty())
                        <div class="text-sm text-gray-500">No purchases found.</div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Invoice</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Supplier</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Amount</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($purchases as $p)
                                        <tr>
                                            <td class="px-6 py-4 text-sm text-gray-500">{{ optional($p->purchase_date)->format('Y-m-d') ?? ($p->created_at?->format('Y-m-d')) }}</td>
                                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $p->invoice_no }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-700">{{ optional($p->supplier)->name }}</td>
                                            <td class="px-6 py-4 text-sm">{{ number_format($p->total_amount, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">{{ $purchases->links() }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
