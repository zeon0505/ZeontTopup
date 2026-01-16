<?php

namespace App\Livewire\Member;

use Livewire\Component;
use App\Models\Referral;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ReferralDashboard extends Component
{
    public $referralCode;
    public $referralLink;

    public function mount()
    {
        $user = Auth::user();
        $this->referralCode = $user->referral_code;
        $this->referralLink = route('register', ['ref' => $this->referralCode]);
    }

    public function render()
    {
        $user = Auth::user();
        
        $stats = [
            'total_referrals' => $user->referredUsers()->count(),
            'total_earnings' => $user->total_commission,
            'pending_earnings' => $user->referrals()->pending()->sum('commission_amount'),
        ];

        $referralHistory = Referral::with('referred', 'order')
            ->where('referrer_id', $user->id)
            ->latest()
            ->paginate(10);

        return view('livewire.member.referral-dashboard', [
            'stats' => $stats,
            'history' => $referralHistory,
        ])->layout('components.layouts.app');
    }
}
