<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    use SoftDeletes;

    /**
     * The products that belong to the Sale
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)->withPivot('price');
    }

    /**
     * The image that belongs to the Sale.
     *
     * @return Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'resource');
    }
}
