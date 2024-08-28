<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
        'description',
        'price',
        'quantity'
    ];

    // boot
    protected static function boot()
    {
        parent::boot();

        // set image attribute when get data into public url
        static::retrieved(function ($product) {
            $product->image = url('uploads/img/' . $product->image);
        });
    }
}
