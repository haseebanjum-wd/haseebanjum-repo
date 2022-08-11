<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Products;

class order_details extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'quantity',
        'price'
    ];

    function products(){
        return $this->belongsTo(Products::class, 'product_id', 'id');
    }

}
