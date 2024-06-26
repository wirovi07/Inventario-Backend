<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Company extends Model
{
    use HasFactory;

    protected $table = 'companies';


    protected $fillable = [
        'nit',
        'name',
        'address',
        'phone',
        'email',
        'user_id'
    ];
}
