<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Display extends Model
{
    use HasFactory;

    protected $fillable=[
      'placeholder',
      'type',
      'display_template',
      'source_page_id',
      'grid_settings_id',
      'slider_settings_id'
    ];
    public function sourcePage(): BelongsTo // every Display have 1 source
    {
        return $this->belongsTo(Page::class, 'source_page_id');
    }
    public function sliderSetting(): BelongsTo
    {
        return $this->belongsTo(SliderSetting::class,'slider_settings_id');
    }
    public function gridSetting(): BelongsTo
    {
        return $this->belongsTo(GridSetting::class,'grid_settings_id');
    }
    public function modules():BelongsToMany
    {
        return $this->belongsToMany(Module::class, 'module_display');
    }
}
