<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'cities';

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
}
