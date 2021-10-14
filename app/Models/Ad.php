<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ad extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ads';

    // 'updated_at' should only be set on 'update'
    protected static function booted(): void {
        static::creating(function (self $model) {
            $model->updated_at = null;
        });

        // this doesn't work, I don't know why
        // static::deleting(function (self $model) {
        //     $model->updated_at = null;
        // });
    }

    /**
     * Get the ad's category
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'id_category');
    }

    /**
     * Get the ad's subcategory
     */
    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class, 'id_subcategory');
    }

    /**
     * Get the ad's city
     */
    public function city()
    {
        return $this->belongsTo(City::class, 'id_city');
    }
}
