<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Employ extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'type_document',
        'document',
        'first_name',
        'employee_position',
        'hire_date',
        'salary',
        'sex',
        'address',
        'phone',
        'email',
        'company_id'
    ];
}
