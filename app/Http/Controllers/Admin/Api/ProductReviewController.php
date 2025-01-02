<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\ProductReview;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductReviewController extends Controller
{

    public function index()
    {
        $reviews = ProductReview::all();

        return response()->json([
            'success' => true,
            'message' => 'All reviews retrieved successfully.',
            'data' => $reviews
        ], 200);
    }

    public function getReviewsByProduct($productId)
    {

        $product = Product::find($productId);
        if (!$product) {
            \Log::error('Ürün bulunamadı', ['productId' => $productId]);
            return response()->json([
                'success' => false,
                'message' => 'Product not found.'
            ], 404);
        }
        

        $reviews = ProductReview::where('product_id', $productId)->get();

        $reviews = $reviews->map(function($review) {
            $review->profile_name = $review->profile_name ?: 'Default User';
            $review->profile_photo = $review->profile_photo ?: 'profile_photos/default.jpg';
            return $review;
        });

        return response()->json([
            'success' => true,
            'message' => 'Reviews for product retrieved successfully.',
            'data' => $reviews
        ], 200);
    }

    public function store(Request $request)
    {


        $validate = Validator::make($request->all(),[
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'profile_name' => 'required|string',
            'comment' => 'required|string',
            'like' => 'nullable|integer',
            'dislike' => 'nullable|integer',
            'time' => 'nullable|date',
            'common_review' => 'nullable|integer',
            'product_id' => 'required|exists:products,id',
        ]);

        if($validate->fails()){
            return response()->json(['error'=>$validate->errors()], 400);
        }

        $review = new ProductReview();

        $review->fill($request->all());

        if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')->store('profile_photos', 'public'); 
            $review->profile_photo = $path;
        }
        


        if($review->save()){

        return response()->json([
            'success' => true,
            'message' => 'Review created successfully.',
            'data' => $review
        ], 201);}else{
            return response()->json([
                'error' => 'Error creating review.'
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'profile_photo' => 'nullable|string',
            'profile_name' => 'required|string',
            'comment' => 'required|string',
            'like' => 'nullable|integer',
            'dislike' => 'nullable|integer',
            'time' => 'nullable|date',
            'common_review' => 'nullable|integer',
            'product_id' => 'required|exists:products,id',
        ]);

        $review = ProductReview::findOrFail($id);
        $review->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Review updated successfully.',
            'data' => $review
        ], 200);
    }

    public function destroy($id)
    {
        $review = ProductReview::findOrFail($id);
        $review->delete();

        return response()->json([
            'success' => true,
            'message' => 'Review deleted successfully.'
        ], 200);
    }
}
