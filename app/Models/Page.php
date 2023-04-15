<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

use Illuminate\Database\Eloquent\Builder;
class Page extends Model
{
    use HasFactory;

protected $fillable = [
    'type',
    'title',
    'sub_title',
    'url',
    'tags',
    'short_description',
    'header_image_url',
    'cover_image_url',
    'hidden',
    'parent_id'
];

    public function parent(): BelongsTo  // a page can have 1 parent
    {
        return $this->belongsTo(Page::class, 'parent_id');
    }

    public function children(): HasMany  // a page can have many children (be a parent to many pages)
    {
        return $this->hasMany(Page::class, 'parent_id');
    }

    public function displays():HasMany // a page can be sourced by many displays
    {
        return $this->hasMany(Display::class);
    }
    public function modules():BelongsToMany // every page has many modules
    {
        return $this->belongsToMany(Module::class,'page_module');
    }

}
