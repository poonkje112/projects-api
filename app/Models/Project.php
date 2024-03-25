<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'title',
        'description',
        'git',
        'live',
        'youtube'
    ];

    protected $hidden = [
        'pivot'
    ];

    public function members()
    {
        return $this->belongsToMany(Member::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function getRouteByKeyName()
    {
        return 'slug';
    }

    public function getCover() {
        // Get the first image that is marked as a cover or the first image
        return $this->images->firstWhere('is_cover', true) ?? $this->images->first();
    }
}
