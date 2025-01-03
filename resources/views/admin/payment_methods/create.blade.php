@extends('admin.layout.layout')

@section('content')
    <div class="container mt-5">
        <h1 class="display-5 pb-3 pt-3">Add new Payment Methods</h1>

        @if(Session::has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>{{ session('error') }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Add Payment info</h5>
            </div>

            <div class="card-body">
                <form action="{{ route('admin.payment_methods.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="img">Image</label>
                        <input type="file" name="img" accept="image/*" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="title">Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Payment methods</button>
                    <a href="{{ route('admin.payment_methods.index') }}" class="btn btn-secondary">Back to Payment List</a>
                </form>
            </div>
        </div>
    </div>
@endsection
