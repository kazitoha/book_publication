<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookInSeller extends Model
{
    use HasFactory;
    protected $table='books_in_seller';
    use HasFactory;
    protected $fillable = [
        'seller_id',
        'class_id',
        'subject_id',
        'total_unit'
    ];





    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subjects::class, 'subject_id');
    }

    public function seller(){
        return $this->belongsTo(User::class, 'seller_id');
    }
}
