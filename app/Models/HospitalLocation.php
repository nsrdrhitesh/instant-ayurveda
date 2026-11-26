<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HospitalLocation extends Model
{
    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'featured' => 'boolean',
            'published' => 'boolean',
            'display_order' => 'integer',
        ];
    }

    public function scopePublished($query)
    {
        return $query->where('published', true);
    }
}
