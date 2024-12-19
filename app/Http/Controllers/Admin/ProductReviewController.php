<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductReview;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;



class ProductReviewController extends Controller
{
    public function index()
    {
        $reviews = ProductReview::all();
        return response()->json([
            'success' => true,
            'message' => 'All reviews retrieved successfully.',
            'data' => $reviews,
        ], 200);
    }
    
    public function create()
    {
        $products = Product::all();
    
        return response()->json([
            'success' => true,
            'data' => $products
        ], 200);
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'profile_name' => 'required|string',
            'comment' => 'required|string',
            'like' => 'nullable|integer',
            'dislike' => 'nullable|integer',
            'time' => 'nullable|date',
            'common_review' => 'nullable|integer',
            'product_id' => 'required|exists:products,id',
        ]);
    
        if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')->store('profile_photos', 'public');
            $validated['profile_photo'] = $path;
        }
    
        $review = ProductReview::create($validated);
    
        return response()->json([
            'success' => true,
            'message' => 'Review created successfully.',
            'data' => $review,
        ], 201);
    }
    
    public function edit($id)
    {
        $review = ProductReview::findOrFail($id);
        $products = Product::all();

        return view('admin.product_reviews.edit', compact('review', 'products')); // Ürünleri view'e gönder
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'profile_name' => 'required|string',
            'comment' => 'required|string',
            'like' => 'nullable|integer',
            'dislike' => 'nullable|integer',
            'time' => 'nullable|date',
            'common_review' => 'nullable|integer',
            'product_id' => 'required|exists:products,id',
        ]);
    
        $review = ProductReview::findOrFail($id);
    
        if ($request->hasFile('profile_photo')) {
            if ($review->profile_photo) {
                Storage::disk('public')->delete($review->profile_photo);
            }
            $path = $request->file('profile_photo')->store('profile_photos', 'public');
            $validated['profile_photo'] = $path;
        }
    
        $review->update($validated);
    
        return response()->json([
            'success' => true,
            'message' => 'Review updated successfully.',
            'data' => $review,
        ], 200);
    }
    
    public function destroy($id)
    {
        $review = ProductReview::findOrFail($id);
    
        if ($review->profile_photo) {
            Storage::disk('public')->delete($review->profile_photo);
        }
    
        $review->delete();
    
        return response()->json([
            'success' => true,
            'message' => 'Review deleted successfully.',
        ], 200);
    }
    public function likeReview($id)
    {
        $review = ProductReview::find($id);
        if ($review) {
            $review->likes += 1;
            $review->save();
            return response()->json(['likes' => $review->likes]);
        }
        return response()->json(['message' => 'Review not found'], 404);
    }
    
    public function dislikeReview($id)
    {
        $review = ProductReview::find($id);
        if ($review) {
            $review->dislikes += 1;
            $review->save();
            return response()->json(['dislikes' => $review->dislikes]);
        }
        return response()->json(['message' => 'Review not found'], 404);
    }
    
    

}
