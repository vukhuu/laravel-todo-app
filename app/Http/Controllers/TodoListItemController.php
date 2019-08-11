<?php

namespace App\Http\Controllers;

use App\TodoListItem;
use Illuminate\Http\Request;
use App\Repositories\Contracts\TodoListItemRepositoryInterface;

class TodoListItemController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, TodoListItemRepositoryInterface $repo)
    {
        return $repo->create($request->all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TodoListItem  $todoListItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TodoListItem $todoListItem, TodoListItemRepositoryInterface $repo)
    {
        $repo->update($todoListItem, $request->all());
        return $todoListItem;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TodoListItem  $todoListItem
     * @param  TodoListItemRepositoryInterface  $repo
     * 
     * @return \Illuminate\Http\Response
     */
    public function destroy(TodoListItem $todoListItem, TodoListItemRepositoryInterface $repo)
    {
        $repo->destroy($todoListItem);
        return $todoListItem;
    }

    /**
     * Mark an item as done
     *
     * @param  \App\TodoListItem  $todoListItem
     * @param  TodoListItemRepositoryInterface  $repo
     * 
     * @return \Illuminate\Http\Response
     */
    public function markDone(TodoListItem $todoListItem, TodoListItemRepositoryInterface $repo)
    {
        $repo->markDone($todoListItem);
        return $todoListItem;
    }

    /**
     * Mark an item as undone
     *
     * @param  \App\TodoListItem  $todoListItem
     * @param  TodoListItemRepositoryInterface  $repo
     * 
     * @return \Illuminate\Http\Response
     */
    public function undoMarkDone(TodoListItem $todoListItem, TodoListItemRepositoryInterface $repo)
    {
        $repo->undoMarkDone($todoListItem);
        return $todoListItem;
    }
}
