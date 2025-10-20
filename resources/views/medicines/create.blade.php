@extends('layouts.app')

@section('content')
<h2>Create Medicine</h2>
<form method="POST" action="{{ route('medicines.store') }}">
  @csrf
  SKU: <input name="sku" /><br/>
  Name: <input name="name" /><br/>
  Type:
  <select name="medicine_type_id">
    @foreach($types as $t)
      <option value="{{ $t->id }}">{{ $t->name }}</option>
    @endforeach
  </select><br/>
  Unit: <input name="unit" /><br/>
  Price: <input name="price_per_unit" /><br/>
  <button type="submit">Create</button>
</form>
@endsection
