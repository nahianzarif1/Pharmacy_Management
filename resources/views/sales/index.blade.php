<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Sales') }}</h2>
            <a href="{{ route('sales.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">New Sale</a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-alert />

            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <div class="p-6">
                    @if($sales->isEmpty())
                        <div class="text-sm text-gray-500">No sales found.</div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Invoice</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($sales as $s)
                                        <tr>
                                            <td class="px-6 py-4 text-sm text-gray-500">{{ $s->created_at?->format('Y-m-d') }}</td>
                                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $s->invoice_no }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-700">{{ $s->customer_name }}</td>
                                            <td class="px-6 py-4 text-sm">{{ number_format($s->total, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">{{ $sales->links() }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
