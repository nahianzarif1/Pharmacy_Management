@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Edit Medicine</h2>

    <form action="{{ route('medicines.update', $medicine->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="{{ $medicine->name }}" required>
        </div>

        <div class="mb-3">
            <label>Type</label>
            <select name="type_id" class="form-control" required>
                @foreach($types as $type)
                    <option value="{{ $type->id }}" {{ $type->id == $medicine->type_id ? 'selected' : '' }}>
                        {{ $type->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Price</label>
            <input type="number" step="0.01" name="price" class="form-control" value="{{ $medicine->price }}" required>
        </div>

        <div class="mb-3">
            <label>Quantity</label>
            <input type="number" name="quantity" class="form-control" value="{{ $medicine->quantity }}" required>
        </div>

        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('medicines.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
