<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subjects extends Model
{
    use HasFactory;
    protected $fillable = [
        'class_id',
        'name',
        'total_unit',
    ];


    public function classes()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }
}
