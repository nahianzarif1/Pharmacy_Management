@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6">
    <div class="max-w-2xl mx-auto bg-white shadow sm:rounded-lg p-6">
        <div class="flex items-start justify-between">
            <div>
                <h2 class="text-xl font-semibold">{{ $supplier->name }}</h2>
                <p class="text-sm text-gray-500">{{ $supplier->contact_name }}</p>
            </div>
            @if(session('error'))
                <div class="w-full mt-4 lg:mt-0 lg:ml-4">
                    <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-800 rounded">{{ session('error') }}</div>
                </div>
            @endif
            <div class="text-right">
                <a href="{{ route('suppliers.edit', $supplier) }}" class="inline-flex items-center px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 mr-2">Edit</a>
                <form action="{{ route('suppliers.destroy', $supplier) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this supplier?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">Delete</button>
                </form>
            </div>
        </div>

        <div class="mt-6 grid grid-cols-1 gap-4">
            <div>
                <h3 class="text-sm font-medium text-gray-500">Phone</h3>
                <div class="text-sm text-gray-900">{{ $supplier->phone }}</div>
            </div>

            <div>
                <h3 class="text-sm font-medium text-gray-500">Email</h3>
                <div class="text-sm text-gray-900">{{ $supplier->email ?? '-' }}</div>
            </div>

            <div>
                <h3 class="text-sm font-medium text-gray-500">Address</h3>
                <div class="text-sm text-gray-900 whitespace-pre-line">{{ $supplier->address ?? '-' }}</div>
            </div>
        </div>
    </div>
</div>
@endsection
