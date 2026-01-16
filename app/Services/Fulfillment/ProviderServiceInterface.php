<?php

namespace App\Services\Fulfillment;

use App\Models\Order;

interface ProviderServiceInterface
{
    /**
     * Process order to provider
     * 
     * @param Order $order
     * @return array Response from provider
     */
    public function processOrder(Order $order): array;

    /**
     * Check order status from provider
     * 
     * @param Order $order
     * @return array Current status information
     */
    public function checkStatus(Order $order): array;

    /**
     * Get provider balance
     * 
     * @return float
     */
    public function getBalance(): float;
}
