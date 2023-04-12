<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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



    public function modules(): HasMany //CSS class might exist in many modules
    {
        return $this->hasMany(Module::class);
    }

    public function sliderSetting():HasMany
    {
        return $this->hasMany(SliderSetting::class);
    }
    public function gridSetting():HasMany
    {
        return $this->hasMany(GridSetting::class);
    }

}
