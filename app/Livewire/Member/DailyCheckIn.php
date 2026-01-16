<?php

namespace App\Livewire\Member;

use Livewire\Component;
use App\Models\CheckIn;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DailyCheckIn extends Component
{
    public $hasCheckedIn = false;
    public $streak = 0;
    public $nextReward = 50;

    public function mount()
    {
        $this->loadStatus();
    }

    public function loadStatus()
    {
        $user = Auth::user();
        $lastCheckIn = CheckIn::where('user_id', $user->id)->latest()->first();

        if ($lastCheckIn) {
            $this->hasCheckedIn = $lastCheckIn->created_at->isToday();
            
            if ($lastCheckIn->created_at->isYesterday() || $lastCheckIn->created_at->isToday()) {
                $this->streak = $lastCheckIn->streak;
            } else {
                $this->streak = 0;
            }
        }
        
        $this->nextReward = 50 + ($this->streak * 10);
    }

    public function checkIn()
    {
        if ($this->hasCheckedIn) return;

        $user = Auth::user();
        $lastCheckIn = CheckIn::where('user_id', $user->id)->latest()->first();
        
        $newStreak = 1;
        if ($lastCheckIn && $lastCheckIn->created_at->isYesterday()) {
            $newStreak = $lastCheckIn->streak + 1;
        }

        $points = 50 + (($newStreak - 1) * 10);

        CheckIn::create([
            'user_id' => $user->id,
            'points_awarded' => $points,
            'streak' => $newStreak,
        ]);

        $user->increment('points', $points);
        $user->addXp(10); // 10 XP per check-in

        // Check for achievements
        $achievementService = new \App\Services\AchievementService();
        $awarded = $achievementService->checkAndAward($user, 'streak_days');
        
        $msg = "Berhasil absen! Kamu dapat $points poin.";
        if (count($awarded) > 0) {
            $msg .= " Kamu juga mendapatkan medal baru: " . $awarded[0]->name;
        }

        $this->loadStatus();
        session()->flash('checkin_success', $msg);
        $this->dispatch('points-updated');
    }

    public function render()
    {
        return view('livewire.member.daily-check-in');
    }
}
