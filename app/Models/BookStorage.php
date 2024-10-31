<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookStorage extends Model
{
    use HasFactory;
    protected $table = 'book_storage';
    protected $fillable = [
        'batch',
        'printing_press_id',
        'class_id',
        'subject_id',
        'unit_price',
        'total_unit',
        'paid_amount',
    ];

    public function printingPress()
    {
        return $this->belongsTo(PrintingPress::class, 'printing_press_id');
    }
    public function subject()
    {
        return $this->belongsTo(Subjects::class, 'subject_id');
    }
    public function classes()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }
}
