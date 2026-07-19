<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderSubmitController extends Controller
{
    /**
     * Accept a public order submission from the landing page form.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_name'  => ['required', 'string', 'max:255'],
            'address'        => ['required', 'string', 'max:1000'],
            'phone'          => ['required', 'string', 'max:20'],
            'note'           => ['nullable', 'string', 'max:1000'],
            'package_name'   => ['required', 'string', 'max:100'],
            'product_price'  => ['required', 'numeric', 'min:0'],
            'delivery_charge'=> ['required', 'numeric', 'min:0'],
            'total_price'    => ['required', 'numeric', 'min:0'],
        ]);

        $order = Order::create($data);

        return response()->json([
            'success'  => true,
            'order_id' => $order->id,
            'message'  => 'আপনার অর্ডার সফলভাবে জমা হয়েছে! আমরা শীঘ্রই যোগাযোগ করব।',
        ], 201);
    }
}
