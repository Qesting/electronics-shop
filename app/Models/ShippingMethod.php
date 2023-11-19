<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShippingMethod extends Model
{
    /**
     * Get the shipper that owns the ShippingMethods
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function shipper(): BelongsTo
    {
        return $this->belongsTo(Shipper::class);
    }

    /**
     * Get all of the orders for the ShippingMethods
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

}
