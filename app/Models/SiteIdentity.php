<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteIdentity extends Model
{
    use HasFactory;

    protected $fillable = [
      'contact_us',
      'social_media',
      'about',
      'images'
    ];
}
