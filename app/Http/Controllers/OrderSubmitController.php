<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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

        // Trigger Meta Conversions API (CAPI)
        try {
            $lp = \App\Models\LandingPage::getDefault();
            $pixelId = $lp->meta_pixel_id;
            $token = $lp->meta_access_token;

            if ($pixelId && $token) {
                // Prepare user data hashing (SHA256)
                $hashedPhone = hash('sha256', preg_replace('/\D/', '', $order->phone));
                
                // Meta requires lowercase name with whitespaces stripped
                $cleanName = strtolower(str_replace(' ', '', $order->customer_name));
                $hashedName = hash('sha256', $cleanName);

                $payload = [
                    'data' => [
                        [
                            'event_name' => 'Purchase',
                            'event_time' => time(),
                            'action_source' => 'website',
                            'event_source_url' => $request->headers->get('referer') ?? url('/'),
                            'user_data' => [
                                'client_ip_address' => $request->ip(),
                                'client_user_agent' => $request->userAgent(),
                                'ph' => [$hashedPhone],
                                'fn' => [$hashedName]
                            ],
                            'custom_data' => [
                                'currency' => 'BDT',
                                'value' => (float)$order->total_price,
                                'content_type' => 'product',
                                'contents' => [
                                    [
                                        'id' => $order->package_name,
                                        'quantity' => 1,
                                    ]
                                ]
                            ]
                        ]
                    ]
                ];

                Http::post("https://graph.facebook.com/v19.0/{$pixelId}/events?access_token={$token}", $payload);
            }
        } catch (\Exception $e) {
            Log::error('Meta CAPI Error: ' . $e->getMessage());
        }

        return response()->json([
            'success'  => true,
            'order_id' => $order->id,
            'message'  => 'আপনার অর্ডার সফলভাবে জমা হয়েছে! আমরা শীঘ্রই যোগাযোগ করব।',
        ], 201);
    }
}
