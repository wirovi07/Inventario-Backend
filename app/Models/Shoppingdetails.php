<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Shoppingdetails extends Model
{
    use HasFactory;
    
    protected $table = 'shopping_details';

    protected $fillable = [
        'amount',
        'unit_price',
        'subtotal',
        'buy_id',
        'product_id'
    ];
}
