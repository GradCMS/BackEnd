<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GridSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'blocks_count',
        'blocks_per_row',
        'blocks_spacing',
        'blocks_animation',
        'horizontal_alignment',
        'vertical_alignment'
    ];
}
