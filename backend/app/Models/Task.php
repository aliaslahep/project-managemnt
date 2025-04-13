<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model {

    protected $fillable = [
        'title',
        'status',
        'project_id'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function remarks()
    {
        return $this->hasMany(Remark::class);
    }

    public function statusHistories()
    {
        return $this->hasMany(TaskStatusHistory::class);
    }
}
