@extends('admin.layout.layout')

@section('content')
<div class="container mt-4">
    <h1>Shipping Methods</h1>
    <a href="{{ route('admin.shipping.create') }}" class="btn btn-primary mb-3">Add New Shipping Method</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Price</th>
                <th>Delivery Time</th>
                <th>Carrier</th>
                <th>Min Amount</th>
                <th>Max Amount</th>
                <th>Additional Charges</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($shippingMethods as $method)
            <tr>
                <td>{{ $method->id }}</td>
                <td>{{ $method->name }}</td>
                <td>${{ $method->price }}</td>
                <td>{{ $method->delivery_time }}</td>
                <td>{{ $method->carrier }}</td>
                <td>${{ $method->min_amount }}</td>
                <td>${{ $method->max_amount }}</td>
                <td>${{ $method->additional_charges }}</td>
      <td>          @if ($method->image)
    <img src="{{ asset('storage/' . $method->image) }}" alt="{{ $method->name }}" width="100">
@endif</td>

                <td>
                    <a href="{{ route('admin.shipping.edit', $method->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('admin.shipping.destroy', $method->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
