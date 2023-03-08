<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SliderSetting extends Model
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

    public function displays(): HasMany
    {
        return $this->HasMany(Display::class);
    }

    public function cssClass(): BelongsTo{
        return $this->belongsTo(CssClass::class,'class_id');
    }
}
