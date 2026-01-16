<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Referral;
use App\Models\User;

class ReferralManager extends Component
{
    use WithPagination;

    public $search = '';
    public $filterStatus = '';

    protected $queryString = ['search', 'filterStatus'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Referral::with(['referrer', 'referred', 'order.game'])
            ->when($this->search, function($q) {
                $q->whereHas('referrer', function($sq) {
                    $sq->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
                })->orWhereHas('referred', function($sq) {
                    $sq->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterStatus, function($q) {
                $q->where('status', $this->filterStatus);
            });

        $stats = [
            'total_referrals' => Referral::count(),
            'total_commission' => Referral::where('status', 'completed')->sum('commission_amount'),
            'pending_commission' => Referral::where('status', 'pending')->sum('commission_amount'),
            'top_referrer' => User::withCount('referrals')
                ->orderBy('referrals_count', 'desc')
                ->first(),
        ];

        return view('livewire.admin.referral-manager', [
            'referrals' => $query->latest()->paginate(15),
            'stats' => $stats
        ])->layout('components.admin-layout', ['title' => 'Referral Management']);
    }
}
