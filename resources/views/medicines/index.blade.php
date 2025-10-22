@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Medicine List</h2>
    <a href="{{ route('medicines.create') }}" class="btn btn-primary mb-3">Add New Medicine</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Type</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($medicines as $medicine)
            <tr>
                <td>{{ $medicine->id }}</td>
                <td>{{ $medicine->name }}</td>
                <td>{{ $medicine->medicineType->name ?? 'N/A' }}</td>
                <td>{{ $medicine->price }}</td>
                <td>{{ $medicine->quantity }}</td>
                <td>
                    <a href="{{ route('medicines.edit', $medicine->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('medicines.destroy', $medicine->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Delete this medicine?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
