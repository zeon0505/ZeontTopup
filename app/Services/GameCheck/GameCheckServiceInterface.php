<?php

namespace App\Services\GameCheck;

interface GameCheckServiceInterface
{
    /**
     * Check if the account ID is valid for the given game.
     *
     * @param string $gameSlug
     * @param string $accountId
     * @return array{isValid: bool, accountName: ?string, message: ?string}
     */
    public function checkAccountId(string $gameSlug, string $accountId): array;
}
