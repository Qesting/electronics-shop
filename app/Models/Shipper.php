<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Shipper extends Model
{
    use HasFactory;

    /**
     * Get all of the shippingMethods for the Shipper
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function shippingMethods(): HasMany
    {
        return $this->hasMany(ShippingMethod::class);
    }

    /**
     * Get the address of the Shipper.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }
}
