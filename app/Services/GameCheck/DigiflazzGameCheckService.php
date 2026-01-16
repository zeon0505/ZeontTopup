<?php

namespace App\Services\GameCheck;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DigiflazzGameCheckService implements GameCheckServiceInterface
{
    protected $username;
    protected $apiKey;
    protected $baseUrl = 'https://api.digiflazz.com/v1';

    public function __construct()
    {
        $this->username = config('services.digiflazz.username');
        $this->apiKey = config('services.digiflazz.api_key');
    }

    public function checkAccountId(string $gameSlug, string $accountId): array
    {
        // Digiflazz uses specific commands for game check
        // Usually, the command is 'pln-subscribe' for PLN, or other commands for games.
        // For games, it often uses the 'transaction' endpoint with a specific SKU that behaves as a check.
        
        // HOWEVER, many providers have a separate 'check-id' or 'lookup' endpoint.
        // Let's implement the standard Digiflazz lookup if they provide it.
        
        $payload = [
            'username' => $this->username,
            'sign' => md5($this->username . $this->apiKey . 'lookup'),
            'type' => 'pln', // Example, this logic varies per game
            'customer_no' => $accountId
        ];

        // Many top-up sites use dedicated lookup APIs because Digiflazz doesn't support all games' nickname checks.
        // If Digiflazz doesn't support it, we'd use something like 'https://cekid.xyz' or 'https://api.vultr.com' etc.
        
        // For now, let's keep the Mock logic but allow it to be swapped.
        // Real implementation would go here.
        
        return [
            'isValid' => true,
            'accountName' => 'Real User (Simulated)',
            'message' => 'Account found'
        ];
    }
}
