@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6">
    <h1 class="text-2xl font-semibold mb-4">Purchase Items</h1>

    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            @if($items->isEmpty())
                <div class="text-sm text-gray-500">No purchase items found.</div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Purchase</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Medicine</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Quantity</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Unit Cost</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($items as $it)
                                <tr>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ optional($it->purchase)->invoice_no }}</td>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ optional($it->medicine)->name }}</td>
                                    <td class="px-6 py-4 text-sm">{{ $it->quantity }}</td>
                                    <td class="px-6 py-4 text-sm">{{ $it->unit_cost }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $items->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
