<?php

namespace App\Livewire\Member;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\LoyaltyPoint;
use Illuminate\Support\Facades\Auth;

class LoyaltyPoints extends Component
{
    use WithPagination;

    public function render()
    {
        $pointsHistory = LoyaltyPoint::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('livewire.member.loyalty-points', [
            'pointsHistory' => $pointsHistory,
            'user' => Auth::user()
        ]);
    }
}
