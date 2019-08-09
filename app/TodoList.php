<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TodoList extends Model
{
    use SoftDeletes;

    protected $softDelete = true;

    protected $fillable = [
        'title',
        'owner_id',
    ];

    /**
     * Default values of model attributes
     */
    protected $attributes = [
        'title' => '',
    ];

    /**
     * Get TodoListItem models
     */
    public function todoListItems()
    {
        return $this->hasMany(\App\TodoListItem::class);
    }
}
