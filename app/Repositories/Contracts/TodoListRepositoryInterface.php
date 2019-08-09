<?php

namespace App\Repositories\Contracts;

use App\TodoList;

interface TodoListRepositoryInterface
{
    /**
     * Create a todo list along with its todo list items
     * 
     * @param array $listAttributes
     * @param array $items
     * 
     * @return array
     */
    public function createWithItems(array $listAttributes, array $items);

    /**
     * Update a TodoList model
     * 
     * @param TodoList $todoList
     * @param array $newAttributes
     * 
     * @return TodoList
     */
    public function update(TodoList $todoList, array $newAttributes);

    /**
     * Delete a TodoList
     * 
     * @param TodoList $todoList
     */
    public function destroy(TodoList $todoList);
}