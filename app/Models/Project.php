<?php

namespace App\Models;

use App\Models\Task;
use App\Models\User;
use App\Models\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getDateAttribute() {
        $date = strtotime($this->deadline);
        return date('d/m/Y', $date);
    }

    public function scopeActive(Builder $query): void {
        $query->where('updated_at', '>', now()->subDays(30));
    }

    public function scopeSearch(Builder $query, string $searchTerm): void {
        $query->where('title', 'LIKE', '%'.$searchTerm.'%')->orWhere('description', 'LIKE', '%'.$searchTerm.'%');
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function client() {
        return $this->belongsTo(Client::class);
    }

    public function tasks() {
        return $this->hasMany(Task::class);
    }
}
