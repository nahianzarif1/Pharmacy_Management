@extends('layouts.app')

@section('content')
<h2>Medicines</h2>
<a href="{{ route('medicines.create') }}">Add Medicine</a>
<table border="1">
  <tr><th>SKU</th><th>Name</th><th>Type</th><th>Price</th><th>Action</th></tr>
  @foreach($medicines as $m)
    <tr>
      <td>{{ $m->sku }}</td>
      <td>{{ $m->name }}</td>
      <td>{{ $m->type->name ?? '' }}</td>
      <td>{{ $m->price_per_unit }}</td>
      <td>
        <a href="{{ route('medicines.edit', $m) }}">Edit</a>
      </td>
    </tr>
  @endforeach
</table>
{{ $medicines->links() }}
@endsection
