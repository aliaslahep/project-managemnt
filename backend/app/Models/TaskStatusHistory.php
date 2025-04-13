<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskStatusHistory extends Model
{
    protected $fillable = [
        'task_id',
        'status',
        'created_at',
        'updated_at'
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }       
}
