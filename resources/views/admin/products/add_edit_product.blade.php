@extends('admin.layout.layout')

@section('content')
    <div class="container mt-5">
        <h1 class="mb-4">Products</h1>

        @if(Session::has('flash_message_error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>{!! session('flash_message_error') !!}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if(Session::has('flash_message_success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>{!! session('flash_message_success') !!}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <h5>Add Product</h5>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form enctype="multipart/form-data" method="post"
                      action="{{ route('admin.products.add_edit_product', ['id' => $product->id ?? null]) }}"
                      name="add_product" id="add_product" novalidate>
                    @csrf

                    <div class="form-group">
                        <label for="product_name">Product Name</label>
                        <input type="text" name="product_name" id="product_name" class="form-control"
                               value="{{ old('product_name', $product->product_name ?? '') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="product_code">Product Code</label>
                        <input type="text" name="product_code" id="product_code" class="form-control"
                               value="{{ old('product_code', $product->product_code ?? '') }}" required>
                    </div>

                    {{--                <div class="form-group">--}}
                    {{--                    <label for="product_color">Product Color</label>--}}
                    {{--                    <input type="text" name="product_color" id="product_color" class="form-control" value="{{ old('product_color', $product->product_color ?? '') }}" required>--}}
                    {{--                </div>--}}

                    <div class="form-group">
                        <label for="product_colors">Product Colors Stock (multiple)</label>
                        <select name="product_color[]" id="product_color" class="form-control" multiple>
                            @foreach(['red', 'blue', 'green', 'yellow', 'black', 'white', 'orange', 'purple'] as $color)
                                <option value="{{ $color }}"
                                    {{ (is_array(old('product_colors', $product->product_colors ?? [])) && in_array($color, old('product_colors', $product->product_colors ?? []))) ? 'selected' : '' }}>
                                    {{ ucfirst($color) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="product_sizes">Product Sizes Stock (multiple)</label>
                        <select name="product_size[]" id="product_size" class="form-control" multiple>
                            @foreach(['S', 'M', 'L', 'XL', 'XXL'] as $size)
                                <option value="{{ $size }}"
                                    {{ (is_array(old('product_sizes', $product->product_sizes ?? [])) && in_array($size, old('product_sizes', $product->product_sizes ?? []))) ? 'selected' : '' }}>
                                    {{ $size }}
                                </option>
                            @endforeach
                        </select>
                    </div>


                    <div class="form-group">
                        <label for="family_color">Family Color</label>
                        <select name="family_color" id="family_color" class="form-control" required>
                            <option value="" disabled>Select a color</option>
                            @foreach(['red', 'blue', 'green', 'yellow', 'black', 'white', 'orange', 'purple'] as $color)
                                <option
                                    value="{{ $color }}" {{ (old('family_color', $product->family_color ?? '') == $color) ? 'selected' : '' }}>{{ ucfirst($color) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="in_stock">Stokda var</label>
                        <select name="in_stock" id="in_stock" class="form-control">
                            <option value="1" {{ old('in_stock', $product->in_stock ?? 1) == 1 ? 'selected' : '' }}>
                                Bəli
                            </option>
                            <option value="0" {{ old('in_stock', $product->in_stock ?? 1) == 0 ? 'selected' : '' }}>
                                Xeyr
                            </option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="category_id">Category</label>
                        <select name="category_id" id="category_id" class="form-control" required>
                            <option value="" disabled selected>Select a category</option>
                            @foreach($categories as $category)
                                <option
                                    value="{{ $category->id }}" {{ (old('category_id', $product->category_id ?? '') == $category->id) ? 'selected' : '' }}>{{ $category->category_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" class="form-control" rows="4"
                                  required>{{ old('description', $product->description ?? '') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="group_code">Group Code</label>
                        <input name="group_code" id="group_code" class="form-control"
                               rows="4">{{ old('group_code', $product->group_code ?? '') }}
                    </div>

                    <div class="form-group">
                        <label for="product_price">Product Price</label>
                        <input type="number" name="product_price" id="price" class="form-control" step="0.01"
                               value="{{ old('product_price', $product->product_price ?? '') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="discount">Product Discount</label>
                        <input type="number" name="product_discount" id="discount" class="form-control" step="0.01"
                               value="{{ old('product_discount', $product->product_discount ?? '') }}">
                    </div>


                    <div class="form-group">
                        <label for="discount">Product quantity</label>
                        <input type="number" name="quantity" id="discount" class="form-control" step="0.01"
                               value="{{ old('quantity', $product->quantity ?? '') }}">
                    </div>
                    <div class="form-group">
                        <label>Free Shipping</label>
                        <div class="form-check">
                            <input type="checkbox" name="free_shipping" id="free_shipping"
                                   class="form-check-input" {{ (old('free_shipping', $product->free_shipping ?? 0) ? 'checked' : '') }}>
                            <label for="free_shipping" class="form-check-label">Enable free shipping</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Free Changes & Return</label>
                        <div class="form-check">
                            <input type="checkbox" name="free_changes_return" id="free_changes_return"
                                   class="form-check-input" {{ (old('free_changes_return', $product->free_changes_return ?? 0) ? 'checked' : '') }}>
                            <label for="free_changes_return" class="form-check-label">Enable free changes and
                                return</label>
                        </div>
                    </div>

                    <div class="control-group">

                        {{--    <div class="form-group">--}}
                        {{--    <label for="product_size">Size</label>--}}
                        {{--    <select name="product_size" id="product_size" class="form-control" required>--}}
                        {{--        <option value="" disabled>Select a size</option>--}}
                        {{--        @foreach(['S', 'M', 'L', 'XL', 'XXL'] as $size)--}}
                        {{--            <option value="{{ $size }}" {{ (old('product_size', $product->product_size ?? '') == $size) ? 'selected' : '' }}>{{ $size }}</option>--}}
                        {{--        @endforeach--}}
                        {{--    </select>--}}
                        {{--</div>--}}

                    </div>


                    <div class="form-group">
                        <label for="meta_title">Meta Title</label>
                        <input type="text" name="meta_title" id="meta_title" class="form-control"
                               value="{{ old('meta_title', $product->meta_title ?? '') }}">
                    </div>

                    <div class="form-group">
                        <label for="meta_keyword">Meta Keyword</label>
                        <input type="text" name="meta_keyword" id="meta_keyword" class="form-control"
                               value="{{ old('meta_keyword', $product->meta_keyword ?? '') }}">
                    </div>

                    <div class="form-group">
                        <label for="meta_description">Meta Description</label>
                        <textarea name="meta_description" id="meta_description" class="form-control"
                                  rows="4">{{ old('meta_description', $product->meta_description ?? '') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="wash_care">Wash Care Instructions</label>
                        <textarea name="wash_care" id="wash_care" class="form-control"
                                  rows="4">{{ old('wash_care', $product->wash_care ?? '') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="fabric">Fabric</label>
                        <input type="text" name="fabric" id="fabric" class="form-control"
                               value="{{ old('fabric', $product->fabric ?? '') }}">
                    </div>

                    <div class="form-group">
                        <label for="pattern">Pattern</label>
                        <input type="text" name="pattern" id="pattern" class="form-control"
                               value="{{ old('pattern', $product->pattern ?? '') }}">
                    </div>

                    <div class="form-group">
                        <label for="images">Product Images</label>
                        <input type="file" name="images[]" id="images" class="form-control" multiple required>
                    </div>

                    <div class="form-group">
                        <label for="other_images">Other Images</label>
                        <input type="file" name="other_photos[]" id="other_images" class="form-control" multiple required>
                    </div>


                    <button type="submit" class="btn btn-primary mt-3">Add Product</button>
                </form>
            </div>
        </div>
    </div>
@endsection
