<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Module extends Model
{
    use HasFactory;

    protected $fillable = [
        'placeholder',
        'animation_style',
        'title',
        'subtitle',
        'content',
        'width'
    ];

    public function pages(): BelongsToMany // every module can be contained in many pages
    {
        return $this->belongsToMany(Page::class, 'page_module');
    }
    public function cssClass(): BelongsTo{
        return $this->belongsTo(CssClass::class,'class_id');
    }
}
