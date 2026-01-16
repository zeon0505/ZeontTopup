<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $fillable = [
        'code',
        'discount_type',
        'amount',
        'min_purchase',
        'max_discount',
        'valid_from',
        'valid_until',
        'usage_limit',
        'used_count',
        'is_active',
    ];

    protected $casts = [
        'valid_from' => 'datetime',
        'valid_until' => 'datetime',
        'is_active' => 'boolean',
        'amount' => 'decimal:2',
        'min_purchase' => 'decimal:2',
        'max_discount' => 'decimal:2',
    ];

    public function isValid($purchaseAmount = 0)
    {
        if (!$this->is_active) {
            return false;
        }

        if ($this->usage_limit !== null && $this->used_count >= $this->usage_limit) {
            return false;
        }

        $now = now();
        if ($this->valid_from && $now->lt($this->valid_from)) {
            return false;
        }

        if ($this->valid_until && $now->gt($this->valid_until)) {
            return false;
        }

        if ($this->min_purchase && $purchaseAmount < $this->min_purchase) {
            return false;
        }

        return true;
    }

    public function calculateDiscount($purchaseAmount)
    {
        if ($this->discount_type === 'fixed') {
            return min($this->amount, $purchaseAmount);
        }

        $discount = $purchaseAmount * ($this->amount / 100);

        if ($this->max_discount) {
            return min($discount, $this->max_discount);
        }

        return $discount;
    }
}
