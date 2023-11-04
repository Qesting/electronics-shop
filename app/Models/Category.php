<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Category extends Model
{
    /**
     * Get all of the subcategories for the Category
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subcategories(): HasMany
    {
        return $this->hasMany(Category::class, 'supercategory_id', 'id');
    }

    /**
     * Get the supercategory that owns the Category
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function supercategory(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'supercategory_id', 'id');
    }

    /**
     * Get the top level parent that owns the Category
     *
     * @return App\Models\Category
     */
    public function topLevelParent(): Category
    {
        $that = $this;
        while (!is_null($that->supercategory_id)) {
            $that = $that->supercategory;
        }
        return $that;
    }
}
