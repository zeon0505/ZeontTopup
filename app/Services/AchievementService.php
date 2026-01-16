<?php

namespace App\Services;

use App\Models\User;
use App\Models\Achievement;
use App\Models\UserAchievement;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AchievementService
{
    /**
     * Check and award achievements of a specific type for a user.
     * 
     * @param User $user
     * @param string $type
     * @return array List of newly awarded achievements
     */
    public function checkAndAward(User $user, string $type)
    {
        $awarded = [];
        $achievements = Achievement::where('type', $type)->get();

        foreach ($achievements as $achievement) {
            // Check if already awarded
            if ($user->achievements()->where('achievement_id', $achievement->id)->exists()) {
                continue;
            }

            $isQualified = false;
            $currentValue = 0;

            switch ($type) {
                case 'topup_count':
                    $currentValue = $user->orders()->where('status', 'completed')->count();
                    $isQualified = $currentValue >= $achievement->threshold;
                    break;
                case 'spending_total':
                    $currentValue = $user->orders()->where('status', 'completed')->sum('total_price');
                    $isQualified = $currentValue >= $achievement->threshold;
                    break;
                case 'streak_days':
                    // We assume the streak is already tracked in CheckIn model
                    $lastCheckIn = $user->checkIns()->latest()->first();
                    $currentValue = $lastCheckIn ? $lastCheckIn->streak : 0;
                    $isQualified = $currentValue >= $achievement->threshold;
                    break;
                case 'order_count':
                    $currentValue = $user->orders()->where('status', 'completed')->count();
                    $isQualified = $currentValue >= $achievement->threshold;
                    break;
            }

            if ($isQualified) {
                $this->award($user, $achievement);
                $awarded[] = $achievement;
            }
        }

        return $awarded;
    }

    /**
     * Award an achievement to a user.
     */
    private function award(User $user, Achievement $achievement)
    {
        DB::transaction(function () use ($user, $achievement) {
            UserAchievement::create([
                'user_id' => $user->id,
                'achievement_id' => $achievement->id,
                'achieved_at' => Carbon::now(),
            ]);

            $user->notify(new \App\Notifications\PlatformNotification(
                "MEDALI BARU! 🏅",
                "Kamu berhasil mendapatkan medali: {$achievement->name}!",
                "achievement"
            ));

            if ($achievement->reward_points > 0) {
                $user->increment('points', $achievement->reward_points);
            }
        });
    }
}
