<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasUuids;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            if (!$user->referral_code) {
                $user->referral_code = static::generateUniqueReferralCode();
            }
        });
    }

    protected static function generateUniqueReferralCode()
    {
        $code = strtoupper(\Illuminate\Support\Str::random(8));
        while (static::where('referral_code', $code)->exists()) {
            $code = strtoupper(\Illuminate\Support\Str::random(8));
        }
        return $code;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'avatar',
        'balance',
        'password',
        'is_admin',
        'referral_code',
        'referred_by',
        'points',
        'security_pin',
        'level',
        'xp',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
        ];
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function getAvatarUrlAttribute()
    {
        return $this->avatar 
            ? \Illuminate\Support\Facades\Storage::url($this->avatar) 
            : 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=7F9CF5&background=EBF4FF';
    }

    /**
     * Favorite games relationship
     */
    public function favorites()
    {
        return $this->belongsToMany(Game::class, 'user_favorites')
            ->withTimestamps();
    }

    /**
     * Reviews relationship
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Check if user can review a game (has purchased it)
     */
    public function canReviewGame($gameId)
    {
        return $this->orders()
            ->whereHas('items.product', function($q) use ($gameId) {
                $q->where('game_id', $gameId);
            })
            ->where('status', 'completed')
            ->exists();
    }

    /**
     * Check if user already reviewed a game
     */
    public function hasReviewedGame($gameId)
    {
        return $this->reviews()->where('game_id', $gameId)->exists();
    }

    /**
     * Referrals given by the user (as referrer)
     */
    public function referrals()
    {
        return $this->hasMany(Referral::class, 'referrer_id');
    }

    /**
     * User who referred this user
     */
    public function referrer()
    {
        return $this->belongsTo(User::class, 'referred_by');
    }

    /**
     * Users referred by this user
     */
    public function referredUsers()
    {
        return $this->hasMany(User::class, 'referred_by');
    }

    /**
     * Get total commission earned
     */
    public function getTotalCommissionAttribute()
    {
        return $this->referrals()->completed()->sum('commission_amount');
    }
    /**
     * Loyalty points history relationship
     */
    public function loyaltyPoints()
    {
        return $this->hasMany(LoyaltyPoint::class);
    }

    /**
     * User achievements relationship
     */
    public function achievements()
    {
        return $this->belongsToMany(Achievement::class, 'user_achievements')
            ->withPivot('achieved_at')
            ->withTimestamps();
    }

    /**
     * User check-ins relationship
     */
    public function checkIns()
    {
        return $this->hasMany(CheckIn::class);
    }

    /**
     * Add XP and handle level up
     */
    public function addXp($amount)
    {
        $this->xp += $amount;
        
        $nextLevelXp = $this->level * 1000;
        
        while ($this->xp >= $nextLevelXp) {
            $this->xp -= $nextLevelXp;
            $this->level++;
            $nextLevelXp = $this->level * 1000;
            
            // Award Rp 1,000 for every level up
            $this->increment('balance', 1000);

            // Logic for level up notification
            $this->notify(new \App\Notifications\PlatformNotification(
                "LEVEL UP! 🚀",
                "Selamat! Kamu sekarang Level {$this->level}. Bonus Saldo Rp 1.000 telah ditambahkan!",
                "level_up"
            ));
        }
        
        $this->save();
    }
}
