<?php

namespace App\Http\Controllers;

use App\TodoList;
use Illuminate\Http\Request;
use App\Repositories\Contracts\TodoListRepositoryInterface;
use Illuminate\Http\Response;

class TodoListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return TodoList::with(['todoListItems'])->orderBy('id', 'desc')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, TodoListRepositoryInterface $listRepository)
    {
        $request->validate([
            'title' => 'required|max:100',
            'todo_list_items.*.name' => 'required|max:100'
        ]);

        $listAttributes = $request->only(['title']);
        $listAttributes['owner_id'] = auth()->id();
        $items = $request->get('todo_list_items');
        $list = $listRepository->createWithItems($listAttributes, $items);

        return $list;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TodoList  $todoList
     * @return \Illuminate\Http\Response
     */
    public function show(TodoList $todoList)
    {
        return $todoList;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TodoList  $todoList
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TodoList $todoList,
                            TodoListRepositoryInterface $listRepository)
    {
        $listRepository->update($todoList, $request->all());

        return $todoList;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TodoList  $todoList
     * @param  TodoListRepositoryInterface $listRepository
     * 
     * @return \Illuminate\Http\Response
     */
    public function destroy(TodoList $todoList, TodoListRepositoryInterface $listRepository)
    {
        $listRepository->destroy($todoList);
        return $todoList;
    }
}
