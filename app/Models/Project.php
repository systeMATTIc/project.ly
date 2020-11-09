<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ["user_id", "name", "description"];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function (self $project) {
            $project->tasks()->delete();
        });
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function completedTasks()
    {
        return $this->tasks()->where(["is_completed" => true]);
    }

    public function incompleteTasks()
    {
        return $this->tasks()->where(["is_completed" => false]);
    }
}
