<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;


class Category extends Model
{

    use HasRecursiveRelationships;
    use HasFactory;

    public function getParentKeyName()
    {
        return 'supercategory_id';
    }

    /**
     * Get all of the products for the Category
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

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

    /**
     * Get the image that belongs to the Category
     *
     * @return \Illuminate\Support\Database\Eloquent\Relations\MorphOne
     */
    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'resource');
    }
}

