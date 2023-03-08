<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SilderSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'slides_per_row',
        'slides_per_column',
        'total_slides',
        'slides_spacing',
        'center_slides',
        'loop_slides',
        'auto_height',
        'stretch_height',
        'auto_play',
        'arrows',
        'bullets',
        'animation',
        'effect_speed_ms'
    ];
}
