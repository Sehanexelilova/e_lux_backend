<?php
namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\PaymentMethods;
use Illuminate\Http\Request;

use Validator;

class PaymentController extends Controller
{
    public function processPayment(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'paymentMethodId' => 'required|exists:payment_methods,id',
            'card_details.cardholderName' => 'required_if:paymentMethodId,1|string|max:255',
            'card_details.cardNumber' => 'required_if:paymentMethodId,1|string|max:16',
            'card_details.expirationDate' => 'required_if:paymentMethodId,1|string|max:5',
            'card_details.cvc' => 'required_if:paymentMethodId,1|string|max:4',
            'card_details.postalCode' => 'required_if:paymentMethodId,1|string|max:10',
            'totalAmount' => 'required|numeric|min:0',
            'products' => 'required|array',
            'products.*.id' => 'required|integer',
            'products.*.name' => 'required|string|max:255',
            'products.*.price' => 'required|numeric|min:0',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        if ($validate->fails()) {
            return response()->json(['error' => $validate->errors()], 400);
        }

        $paymentMethod = PaymentMethods::find($request->paymentMethodId);

        switch ($paymentMethod->name) {
            case 'PayPal':

                break;
            case 'Apple Pay':

                break;
            case 'Credit Card':
                $card_details = $request->card_details;

                break;
            default:
                return response()->json(['message' => 'Unsupported payment method'], 400);
        }

        $quantity = 0;
        foreach ($request->products as $product) {
            $quantity += $product['quantity'];

        }

        $dummyAdress = ["New York 2965 Veterans Rd W", "New York Hamilton Ontario", "United States High Wycombe"];
        $order = Order::create([
            'user_id' => auth()->user()->id,
            "basket_id" => auth()->user()->basket->id,
            'total_amount' => $request->totalAmount,
            "uid" => uniqid(),
            "status" => 0,
            'quantity' => $quantity,
            "address" => $dummyAdress[rand(0, count($dummyAdress) - 1)],
            "payment_type" => $paymentMethod->name,
            "total" => $request->totalAmount
        ]);


        foreach ($request->products as $product) {
            OrderDetail::create([
                'order_id' => $order->id,
                'uid' => $order->uid,
                'product_id' => $product['id'],
                'quantity' => $product['quantity'],
                'product_name' => $product['name'],
                'size' => $product['size'],
                'price' => $product['price'],
                'total' => $product['price'] * $product['quantity'],
                'image' => $product['image'],
                'date' => now(),

            ]);
        }




        $paymentInfo = [
            'order_id' => $order->id,
            'payment_method' => $paymentMethod->name,
            'total_amount' => $request->totalAmount,
            'card_details' => $paymentMethod->name === 'Credit Card' ? json_encode($request->card_details) : null,
            'products' => json_encode($request->products),
        ];

        \DB::table('payments')->insert(array_merge($paymentInfo, [
            'created_at' => now(),
            'updated_at' => now(),
        ]));
        \DB::table('basket_products')->where('basket_id', auth()->user()->basket->id)->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Payment processed successfully!',
            'order' => $order
        ], 200);
    }
    public function getPaymentMethods()
    {
        $methods = PaymentMethods::all();
        return response()->json(['data' => $methods]);
    }
    public function getOrderInfo()
    {
        $user_id = auth()->user()->id;
        $order = Order::with('details')->where('user_id', $user_id)->orderBy('created_at', 'desc')->first();
        return response()->json(['data' => $order]);
    }
}
