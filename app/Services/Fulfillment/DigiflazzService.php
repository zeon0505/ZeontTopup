<?php

namespace App\Services\Fulfillment;

use App\Models\Order;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DigiflazzService implements ProviderServiceInterface
{
    protected $username;
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->username = config('services.digiflazz.username');
        $this->apiKey = config('services.digiflazz.api_key');
        $this->baseUrl = config('services.digiflazz.mode') === 'production' 
            ? 'https://api.digiflazz.com/v1' 
            : 'https://api.digiflazz.com/v1'; // Digiflazz often uses the same URL but different keys/payloads or a dedicated sandbox URL
            
        // Note: For Digiflazz, sandbox is often reached via specific product codes or a different endpoint if provided.
        // Usually, it's the same endpoint but you use the Development Key.
    }

    protected function generateSign($command): string
    {
        return md5($this->username . $this->apiKey . $command);
    }

    public function processOrder(Order $order): array
    {
        $product = $order->items()->first()->product; // Assuming 1 product per order for top-up
        
        if (!$product || !$product->provider_product_code) {
            return [
                'success' => false,
                'message' => 'Product provider code not found.'
            ];
        }

        $payload = [
            'username' => $this->username,
            'buyer_sku_code' => $product->provider_product_code,
            'customer_no' => $order->game_account_id,
            'ref_id' => $order->order_number,
            'sign' => $this->generateSign($order->order_number)
        ];

        try {
            $response = Http::post($this->baseUrl . '/transaction', $payload);
            $data = $response->json();

            Log::info('Digiflazz Order Response', ['order' => $order->order_number, 'response' => $data]);

            if (isset($data['data'])) {
                $status = $data['data']['status'];
                
                return [
                    'success' => true,
                    'status' => $status, // 'Pending', 'Success', 'Gagal'
                    'message' => $data['data']['message'] ?? '',
                    'sn' => $data['data']['sn'] ?? '',
                    'raw' => $data
                ];
            }

            return [
                'success' => false,
                'message' => $data['message'] ?? 'Unknown error from Digiflazz'
            ];

        } catch (\Exception $e) {
            Log::error('Digiflazz API Error', ['error' => $e->getMessage()]);
            return [
                'success' => false,
                'message' => 'Connection to provider failed.'
            ];
        }
    }

    public function checkStatus(Order $order): array
    {
        $product = $order->items()->first()->product;
        
        $payload = [
            'username' => $this->username,
            'buyer_sku_code' => $product->provider_product_code,
            'customer_no' => $order->game_account_id,
            'ref_id' => $order->order_number,
            'sign' => $this->generateSign($order->order_number)
        ];

        try {
            $response = Http::post($this->baseUrl . '/transaction', $payload);
            $data = $response->json();

            if (isset($data['data'])) {
                return [
                    'success' => true,
                    'status' => $data['data']['status'],
                    'sn' => $data['data']['sn'] ?? '',
                    'message' => $data['data']['message'] ?? ''
                ];
            }

            return ['success' => false, 'message' => 'Status check failed.'];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function getBalance(): float
    {
        $payload = [
            'cmd' => 'deposit',
            'username' => $this->username,
            'sign' => $this->generateSign('depo')
        ];

        try {
            $response = Http::post($this->baseUrl . '/cek-saldo', $payload);
            $data = $response->json();

            return (float) ($data['data']['deposit'] ?? 0);
        } catch (\Exception $e) {
            return 0;
        }
    }
}
