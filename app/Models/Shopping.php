<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Shopping extends Model
{
    use HasFactory;

    protected $table = 'shopping';

    protected $fillable = [
        'date',
        'total',
        'company_id',
        'supplier_id'
    ];
}
