<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Saledetails extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'amount',
        'unit_price',
        'subtotal',
        'sale_id',
        'product_id'
    ];
}
