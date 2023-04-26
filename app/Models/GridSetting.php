<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GridSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'blocks_count',
        'blocks_per_row',
        'blocks_spacing',
        'class_id',
        'blocks_animation',
        'horizontal_alignment',
        'vertical_alignment'
    ];

    public function displays(): HasMany
    {
        return $this->HasMany(Display::class);
    }

    public function cssClass(): BelongsTo{
        return $this->belongsTo(CssClass::class,'class_id');
    }
}
