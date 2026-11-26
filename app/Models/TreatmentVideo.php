<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TreatmentVideo extends Model
{
    protected $fillable = ['youtube_id', 'title', 'description', 'category', 'featured', 'published', 'display_order'];

    protected function casts(): array
    {
        return ['featured' => 'boolean', 'published' => 'boolean'];
    }
}
