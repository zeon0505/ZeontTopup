<?php

namespace App\Livewire;

use Livewire\Component;

class AccountIdValidator extends Component
{
    public $gameId;
    public $accountId = '';
    public $isValid = false;
    public $accountName = '';
    public $isLoading = false;
    public $errorMessage = '';
    public $isValidating = false; // Added isValidating property

    public function validateAccount(\App\Services\GameCheck\GameCheckServiceInterface $gameCheckService)
    {
        $this->validate([
            'accountId' => 'required|string|min:3',
        ]);

        $this->isValidating = true;
        $this->errorMessage = '';
        $this->isValid = false;
        $this->accountName = '';

        // Get game slug (assuming gameId is passed)
        // Optimization: In real app, might pass slug directly or cache this
        $game = \App\Models\Game::find($this->gameId);
        $slug = $game ? $game->slug : 'unknown';

        $result = $gameCheckService->checkAccountId($slug, $this->accountId);

        if ($result['isValid']) {
            $this->isValid = true;
            $this->accountName = $result['accountName'];
            $this->dispatch('account-validated', [
                'id' => $this->accountId,
                'name' => $this->accountName,
                'is_valid' => true,
            ]);
        } else {
            $this->isValid = false;
            $this->errorMessage = $result['message'];
            $this->dispatch('account-validation-failed');
        }

        $this->isValidating = false;
    }

    public function render()
    {
        return view('livewire.account-id-validator');
    }
}
