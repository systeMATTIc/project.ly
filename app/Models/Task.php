<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ["project_id", "name", "priority", "is_completed"];

    protected $casts = [
        "is_completed" => "boolean",
        "created_at" => "datetime:Y-m-d h:i:s",
        "updated_at" => "datetime:Y-m-d h:i:s",
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function (self $task) {
            $task->priority = self::getLeastPriority($task);
        });
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public static function getLeastPriority($task)
    {
        $leastImportantTask = static::where("project_id", $task->project_id)
            ->orderBy('priority', 'desc')
            ->first();

        if (is_null($leastImportantTask)) {
            return 1;
        }

        return $leastImportantTask->priority + 1;
    }
}
