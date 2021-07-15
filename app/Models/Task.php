<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $hidden = [
        'user_id',
        'updated_at',
        'created_at'
    ];

    public function getRouteKeyName()
    {
        return 'identifier';
    }

    public function todolist()
    {
        return $this->belongsTo(Todolist::class);
    }
}
