<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\order_details;
use App\Models\User;

class orders extends Model
{
    use HasFactory;

    protected $fillable = [
        'total_price',
        'status',
    ];
    
    function orderDetails(){
        return $this->hasMany(order_details::class, 'order_id', 'id');
    }

    function users(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
