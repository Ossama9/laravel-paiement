<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe;

class PaymentController extends Controller
{
    public function processPayment(Request $request)
    {
        return redirect(route('payment.cancel'));
    }

    public function cancel(Request $request)
    {
        echo 'cancel';
    }

    public function success(Request $request)
    {
        echo 'success';
    }

    public function goPayment(Request $request)
    {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'EUR',
                        'product_data' => [
                            'name' => 'Product 1',
                            'images' => [
                                'https://picsum.photos/280/320?random=4',
                                'https://picsum.photos/280/320?random=2',
                            ]
                        ],
                        'unit_amount' => 10000,
                    ],
                    'quantity' => 1,
                ]
            ],
            'mode' => 'payment',
            'success_url' => route('payment.success'),
            'cancel_url' => route('payment.cancel'),
        ]);
        return redirect($session->url);
    }
}
