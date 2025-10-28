@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6">
    <h1 class="text-2xl font-semibold mb-4">Stock Movements</h1>

    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            @if($movements->isEmpty())
                <div class="text-sm text-gray-500">No stock movements found.</div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Medicine</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Change</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">By</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($movements as $m)
                                <tr>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        @php
                                            $date = null;
                                            if(isset($m->created_at)){
                                                // created_at might be a Carbon instance or a string
                                                $date = is_object($m->created_at) && method_exists($m->created_at, 'format')
                                                    ? $m->created_at->format('Y-m-d H:i')
                                                    : \Carbon\Carbon::parse($m->created_at)->format('Y-m-d H:i');
                                            }
                                        @endphp
                                        {{ $date ?? '' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ optional($m->medicine)->name }}</td>
                                    <td class="px-6 py-4"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $m->stock_change > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">{{ $m->movement_type }}</span></td>
                                    <td class="px-6 py-4 text-sm font-medium {{ $m->stock_change > 0 ? 'text-green-600' : 'text-red-600' }}">{{ $m->stock_change > 0 ? '+' : '' }}{{ $m->stock_change }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ optional($m->user)->name ?? 'System' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $movements->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
