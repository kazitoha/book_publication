<?php

// app/Models/UserThemeSetting.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserThemeSetting extends Model
{
    use HasFactory;

    protected $fillable = ['theme_layout', 'sidebar_color', 'theme_color', 'sticky_header', 'sidebar_mini',];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
