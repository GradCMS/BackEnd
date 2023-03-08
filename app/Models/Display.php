<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Display extends Model
{
    use HasFactory;

    protected $fillable=[
      'placeholder',
      'type',
      'display_template',
      'source_page_id'
    ];
    public function sourcePage(): BelongsTo // every Display have 1 source
    {
        return $this->belongsTo(Page::class, 'source_page_id');
    }


}
