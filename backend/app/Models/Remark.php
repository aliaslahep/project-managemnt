<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Remark extends Model {

    protected $fillable = [
        'task_id',
        'date',
        'content',
        'user_id'
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
