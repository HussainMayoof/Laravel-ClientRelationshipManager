<?php

namespace App\Models;

use App\Models\User;
use App\Models\Project;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function projects() {
        return $this->hasMany(Project::class);
    }

    public function clients() {
        return $this->belongsToMany(User::class, 'projects');
    }
}
