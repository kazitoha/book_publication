<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreBook extends Model
{
    use HasFactory;
    protected $table='store_book';
    protected $fillable = [
        'printing_press_id',
        'subject_name',
        'total_book',
    ];

    public function printingPress()
    {
        return $this->belongsTo(PrintingPress::class, 'printing_press_id');
    }
}
