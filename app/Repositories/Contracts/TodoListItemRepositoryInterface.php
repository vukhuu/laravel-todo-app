<?php

namespace App\Repositories\Contracts;

use App\TodoListItem;

interface TodoListItemRepositoryInterface
{
    /**
     * Create a todo list item
     * 
     * @param array $listAttributes
     * 
     * @return TodoListItem
     */
    public function create(array $attributes);

    /**
     * Update a TodoListItem model
     * 
     * @param TodoListItem $todoListItem
     * @param array $newAttributes
     * 
     * @return TodoListItem
     */
    public function update(TodoListItem $todoListItem, array $newAttributes);

    /**
     * Delete a TodoListItem
     * 
     * @param TodoListItem $todoListItem
     */
    public function destroy(TodoListItem $todoListItem);

    /**
     * Mark a TodoListItem as done
     * 
     * @param TodoListItem $todoListItem
     */
    public function markDone(TodoListItem $todoListItem);
}