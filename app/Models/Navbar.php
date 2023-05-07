<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Navbar extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
      'referenced_page',
      'name',
      'priority',
      'parent_id'
    ];

    public function parent(): BelongsTo  // a navbar can have 1 parent
    {
        return $this->belongsTo(Navbar::class, 'parent_id');
    }

    public function children(): HasMany  // a navbar can have many children (be a parent to many pages)
    {
        return $this->hasMany(Navbar::class, 'parent_id');
    }

    public function page(): BelongsTo  // a navbar can have 1 parent
    {
        return $this->belongsTo(Page::class, 'referenced_page');
    }
}
