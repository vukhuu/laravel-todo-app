<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TodoListItem extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'todo_list_id',
    ];

    /**
     * Default values of model attributes
     */
    protected $attributes = [
        'name' => '',
    ];

    /**
     * Get TodoList model
     */
    public function getTodoList()
    {
        return $this->belongsTo(\App\TodoList::class);
    }
}
