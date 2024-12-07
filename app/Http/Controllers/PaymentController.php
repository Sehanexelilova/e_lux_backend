<?php
namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\PaymentMethods;
use Illuminate\Http\Request;
use Validator;

class PaymentController extends Controller
{
    public function processPayment(Request $request)
    {
        // // api yazanda validate yox Validator methodunu işlədin 
        $validate = Validator::make($request->all(), [
            'paymentMethodId' => 'required|exists:payment_methods,id',
            'card_details.cardholderName' => 'required_if:paymentMethodId,1|string|max:255', // Credit Card Only
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


        $order = Order::create([
            'user_id' => auth()->user()->id,
            "basket_id" => auth()->user()->basket->id,
            'total_amount' => $request->totalAmount,
            "uid" => uniqid(),
            "status" => 0,
            'quantity' => 1,
            "address" => "Test",
            "payment_type" => $paymentMethod->name,
            "total" => 55
        ]);

        // return response()->json($order, 200);
// nəysə geri qalanı sizlik )))

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

        return response()->json([
            'status' => 'success',
            'message' => 'Payment processed successfully!',
        ], 200);
    }
    public function getPaymentMethods()
    {
        $methods = PaymentMethods::all();
        return response()->json(['data' => $methods]);
    }
}
