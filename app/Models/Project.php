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

    public function members()
    {
        return $this->belongsToMany(Member::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
