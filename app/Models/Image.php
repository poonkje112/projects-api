<?php

namespace App\Models;

use App\Models\Project;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'is_cover' => 0,
        'order' => 0,
        ];

    protected $hidden = [
        'path'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
