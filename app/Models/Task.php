<?php

namespace App\Models;

use App\Models\User;
use App\Models\Project;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function scopeWithProject(Builder $query, Project $project) {
        $query->where('project_id', $project->id);
    }

    public function scopeSearch(Builder $query, string $searchTerm): void {
        $query->where('title', 'LIKE', '%'.$searchTerm.'%')->orWhere('description', 'LIKE', '%'.$searchTerm.'%');
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function project() {
        return $this->belongsTo(Project::class);
    }
}
