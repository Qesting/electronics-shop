<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\HasMany;

class Shipper extends Model
{
    /**
     * Get all of the shippingMethods for the Shipper
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function shippingMethods(): HasMany
    {
        return $this->hasMany(ShippingMethod::class);
    }
}
