<?php

namespace App\Services\GameCheck;

class MockGameCheckService implements GameCheckServiceInterface
{
    public function checkAccountId(string $gameSlug, string $accountId): array
    {
        // Simulate API delay
        sleep(1);

        // Simple mock logic: ID length > 5 is valid
        if (strlen($accountId) > 5) {
            return [
                'isValid' => true,
                'accountName' => 'TestUser_' . substr($accountId, -4),
                'message' => 'Account found.',
            ];
        }

        return [
            'isValid' => false,
            'accountName' => null,
            'message' => 'ID Akun tidak ditemukan (Mock).',
        ];
    }
}
