<?php

namespace App\Models;

use App\Models\Project;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'portfolio'
    ];

    protected $hidden = [
        'pivot'
    ];

    public function projects()
    {
        return $this->belongsToMany(Project::class);
    }
}
