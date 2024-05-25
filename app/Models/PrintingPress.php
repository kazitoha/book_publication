<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrintingPress extends Model
{
    protected $table='printing_press';
    use HasFactory;
    protected $fillable = [
        'name',
        'address',
        'un_paid',
    ];

}
