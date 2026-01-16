<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Product extends Model
{
    use HasUuids;
    protected $fillable = [
        'game_id',
        'name',
        'description',
        'price',
        'original_price',
        'quantity',
        'is_active',
        'provider_name',
        'provider_product_code',
        'sort_order',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'original_price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function flashSales()
    {
        return $this->hasMany(FlashSale::class);
    }

    public function activeFlashSale()
    {
        return $this->hasOne(FlashSale::class)->ofMany([
            'start_time' => 'max',
            'id' => 'max',
        ], function ($query) {
            $query->active();
        });
    }

    public function getPriceAttribute($value)
    {
        if ($this->relationLoaded('activeFlashSale') && $this->activeFlashSale) {
            return $this->activeFlashSale->discount_price;
        }

        // Optimistic check without eager loading if needed, but best to rely on eager load
        // Typically we rely on the controller/view to load 'activeFlashSale'
        
        return $value;
    }
    
    public function getOriginalPriceAttribute($value)
    {
        // If there's an active flash sale, the DB stored price IS the original price.
        // If 'original_price' column is used for strikethrough in general, we use that unless there's a flash sale.
        // Actually, let's keep it simple: 
        // Real Price = Flash Sale Price (if active) OR DB Price.
        // Strikethrough Price = DB Price (if flash sale active) OR DB Original Price.

        return $value;
    }

    public function getFinalPriceAttribute()
    {
        return $this->activeFlashSale ? $this->activeFlashSale->discount_price : $this->attributes['price'];
    }

    public function getHasFlashSaleAttribute()
    {
        return $this->activeFlashSale !== null;
    }
}
