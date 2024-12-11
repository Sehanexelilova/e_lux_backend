<?php

namespace App\Http\Controllers;

use App\Models\BasketProduct;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $orders = Order::with('details')->where('user_id', $user->id)->orderBy('created_at', 'desc')->get();

        if ($orders->isEmpty()) {
            return response()->json([
                "success" => false,
                "message" => "No orders found"
            ]);
        }

        $formattedOrders = $orders->map(function ($order) {
            return [
                'id' => $order->id,
                'created_at' => $order->created_at->format('Y-m-d'),
                'order_details' => $order->details,
                'uid' => $order->uid,
                'address' => $order->address,
                'payment_type' => $order->payment_type,
                'total' => $order->total,
                'status' => $order->status,  // statusu da daxil et
            ];
        });

        return response()->json([
            "data" => $formattedOrders,
            "success" => true,
            "message" => "Orders fetched successfully"
        ]);
    }
    public function adminOrdersIndex()
    {
        $orders = Order::all();
        return view('admin.orders.index', compact('orders'));
    }
    
    public function store(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'address' => 'required|string|max:255',
            'payment_type' => 'required|string|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $user = Auth::user();
        $basketProducts = BasketProduct::where('basket_id', $user->basket->id)->get();

        if ($basketProducts->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Your basket is empty.'
            ], 400);
        }

        $total = 0;

        $newOrder = Order::create([
            'user_id' => $user->id,
            'basket_id' => $user->basket->id,
            'address' => $req->shipping_addresses,
            'payment_type' => $req->payments,
            'uid' => uniqid(),
            'total' => 0,
            'status' => 0, 
        ]);

        foreach ($basketProducts as $basketProduct) {
            $product = Product::find($basketProduct->product_id);

            if (!$product) {
                continue;
            }

            $subtotal = $product->product_price * $basketProduct->stock_count;

            OrderDetail::create([
                'order_id' => $newOrder->id,
                'product_name' => $product->product_name,
                'size' => $basketProduct->selected_size,
                'date' => now(),
                'price' => $product->product_price,
                'quantity' => $basketProduct->stock_count,
                'total' => $subtotal,
            ]);

            $total += $subtotal;
        }

        $newOrder->update(['total' => $total]);

        BasketProduct::where('basket_id', $user->basket->id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Order created successfully.',
            'order_id' => $newOrder->id
        ]);
    }
  

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|integer|min:0|max:4',
        ]);

        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return redirect()->back()->with('success', 'Order status updated successfully.');
    }

    
}
