@extends('admin.layout.layout')

@section('content')
    <div class="container mt-5">
        <h1 class="display-5 p-3">Edit Partner</h1>

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
                <h5 class="mb-0">Update Partner</h5>
            </div>

            <div class="card-body">
                <form action="{{ route('admin.partners.update', $partner) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Existing Image Preview -->
                    @if($partner->img)
                        <div class="mb-3">
                            <img src="{{ asset('storage/' . $partner->img) }}" alt="Current Image" style="max-width: 200px;">
                        </div>
                    @endif

                    <!-- Image Input -->
                    <div class="form-group">
                        <label for="img">Partner Image:</label>
                        <input type="file" accept="image/*" name="img" id="img" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="title">Title:</label>
                        <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $partner->title) }}" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('admin.partners.index') }}" class="btn btn-secondary">Back to Partner List</a>
                </form>
            </div>
        </div>
    </div>
@endsection