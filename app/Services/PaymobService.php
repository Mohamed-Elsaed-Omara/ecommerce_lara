<?php

namespace App\Services;

use App\Models\Order;
use Exception;
use GuzzleHttp\Client;

class PaymobService
{
    protected $api_key;
    protected $integration_id;
    protected $client;

    public function __construct()
    {
        $this->api_key = env('PAYMOB_API_KEY');
        $this->integration_id = env('PAYMOB_INTEGRATION_ID');
        $this->client = new Client(['base_uri' => 'https://accept.paymob.com/api/']);
    }

    /**
     * Get Authentication Token from Paymob
     */
    public function authenticate()
    {
        try {
            $response = $this->client->post('auth/tokens', [
                'json' => [
                    'api_key' => $this->api_key, // This should be in your .env
                    /* 'username' => env('PAYMOB_USERNAME'), // ensure this is correct
                    'password' => env('PAYMOB_PASSWORD'), // ensure this is correct */
                ]
            ]);

            $data = json_decode($response->getBody(), true);

            return $data['token'];
        } catch (Exception $e) {
            throw new Exception('Authentication failed: ' . $e->getMessage());
        }
    }


    /**
     * Register an Order
     */
    /* public function createOrder($authToken, $amountCents)
    {
        try {
            $response = $this->client->post('ecommerce/orders', [
                'json' => [
                    'auth_token' => $authToken,
                    'delivery_needed' => false,
                    'amount_cents' => $amountCents,
                    'currency' => 'EGP',
                    'items' => []
                ]
            ]);
            return json_decode($response->getBody(), true);
        } catch (Exception $e) {
            throw new Exception('Order creation failed: ' . $e->getMessage());
        }
    } */

    public function createOrder($authToken, $amountCents)
    {
        try {
            $response = $this->client->post('ecommerce/orders', [
                'json' => [
                    'auth_token' => $authToken,
                    'delivery_needed' => false,
                    'amount_cents' => $amountCents,
                    'currency' => 'EGP',
                    'items' => []
                ]
            ]);

            $data = json_decode($response->getBody(), true);

            // Save the Paymob order ID in the database
            $order = Order::create([
                'pay_order_id' => $data['id'], // تخزين الـ id اللي جاي من Paymob
                'amount' => $amountCents,
                'status' => 'pending',
            ]);

            return $data; // ترجع البيانات عشان تستخدمها بعدين
        } catch (Exception $e) {
            throw new Exception('Order creation failed: ' . $e->getMessage());
        }
    }


    /**
     * Generate Payment Key
     */
    public function createPaymentKey($authToken, $orderId, $amountCents, $billingData)
    {
        try {
            $response = $this->client->post('acceptance/payment_keys', [
                'json' => [
                    'auth_token' => $authToken,
                    'amount_cents' => $amountCents,
                    'expiration' => 3600,
                    'order_id' => $orderId,
                    'currency' => 'EGP',
                    'integration_id' => $this->integration_id,
                    'billing_data' => $billingData
                ]
            ]);
            return json_decode($response->getBody(), true);
        } catch (Exception $e) {
            throw new Exception('Payment key generation failed: ' . $e->getMessage());
        }
    }
}
