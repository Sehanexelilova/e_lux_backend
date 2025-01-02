@extends('admin.layout.layout')

@section('content')
<div class="container mt-5">
    <div class="mb-4">
        <h1 class="display-4">Products</h1>

        @if(Session::has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>{{ session('error') }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if(Session::has('flash_message_success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>{{ session('flash_message_success') }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Product List</h5>
            <a href="{{ route('admin.products.add_edit_product', ['id' => null]) }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Add Product
            </a>
        </div>

        <div class="card-body">
            <table class="table table-bordered table-hover table-striped data-table">
                <thead class="thead-dark">
                    <tr>
                        <th>Product ID</th>
                        <th>Product Name</th>
                        <th>Product Style</th>
                        <th>Product Color</th>
                        <th>Gender</th>
                        <th>Quantity</th>
                        <th>Image</th>
                        <th>Status</th>
                        <th>Stock</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td>{{ $product['id'] }}</td>
                            <td>{{ $product['product_name'] }}</td>
                            <td>{{ $product['style'] }}</td>
                            
                            <td>
                                @if(is_array($product['product_color']))
                                    @foreach($product['product_color'] as $color)
                                        <span class="badge" style="background-color: {{ $color }}; color: white;">{{ ucfirst($color) }}</span>
                                    @endforeach
                                @else
                                    <span class="badge badge-secondary">No Colors</span>
                                @endif
                            </td>
                            <td>
                                @if($product['gender'] == 'male')
                                    <span class="badge badge-primary">Kişi</span>
                                @elseif($product['gender'] == 'female')
                                    <span class="badge badge-danger">Qadın</span>
                                @elseif($product['gender'] == 'child')
                                    <span class="badge badge-warning">Uşaq</span>
                                @elseif($product['gender'] == 'unisex')
                                    <span class="badge badge-info">Unisex</span>
                                @endif
                            </td>
                            <td>{{ $product['quantity'] }}</td>
                            <td>
                                @if(!empty($product['image']))
                                <img src="{{ asset('storage/' . $product['image']) }}" class="img-thumbnail" style="width:60px;">
                                @endif
                            </td>
                            <td>
                                <span class="badge badge-{{ $product['status'] == 1 ? 'success' : 'secondary' }}">
                                    {{ $product['status'] == 1 ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                <span class="badge badge-{{ $product['in_stock'] ? 'success' : 'danger' }}">
                                    {{ $product['in_stock'] ? 'Stokda var' : 'Stokda yoxdur' }}
                                </span>
                            </td>
                            <td>
                                <a href="#myModal{{ $product['id'] }}" data-toggle="modal" class="btn btn-info btn-sm" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.products.add_edit_product', ['id' => $product['id']]) }}" class="btn btn-primary btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.delete_product', ['id' => $product['id']]) }}" method="POST" style="display: inline;">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-primary btn-sm" title="delete">
        <i class="fas fa-trash"></i>
    </button>
</form>
                            
                            </td>
                        </tr>

                        <!-- Product Details Modal -->
                        <div id="myModal{{ $product['id'] }}" class="modal fade" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">{{ $product['product_name'] }} Details</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>Product ID:</strong> {{ $product['id'] }}</p>
                                        <p><strong>Product style:</strong> {{ $product['style'] }}</p>
                                        <p>
                                            @if(is_array($product['product_color']))
                                                @foreach($product['product_color'] as $color)
                                                    <span class="badge" style="background-color: {{ $color }}; color: white;">{{ ucfirst($color) }}</span>
                                                @endforeach
                                            @else
                                                <span class="badge badge-secondary">No Colors</span>
                                            @endif
                                        </p>
                                        <p><strong>Price:</strong> {{ $product['product_price'] }}</p>


                                        <p><strong>Fabric:</strong> {{ $product['fabric'] }}</p>
                                        <p><strong>Description:</strong> {{ $product['description'] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
