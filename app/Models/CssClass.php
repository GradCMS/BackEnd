<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CssClass extends Model
{
    use HasFactory;

    protected $fillable = [
        'placeholder',
        'reference_name',
        'json',
        'css',
        'custom_css'
    ];
}
