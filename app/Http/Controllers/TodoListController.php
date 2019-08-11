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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, TodoListRepositoryInterface $listRepository)
    {
        $listAttributes = $request->only(['title']);
        $listAttributes['owner_id'] = auth()->id();
        $items = $request->get('todo_list_items');
        $list = $listRepository->createWithItems($listAttributes, $items);
        
        $listAsArray = $list->attributesToArray();
        $listAsArray['todo_list_items'] = $list->todoListItems;
        $response = new Response();
        //$response->setContent($list->with('todoListItems')->first());
        $response->setContent($listAsArray);
        $response->setStatusCode(201);
        return $response;
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
     * Show the form for editing the specified resource.
     *
     * @param  \App\TodoList  $todoList
     * @return \Illuminate\Http\Response
     */
    public function edit(TodoList $todoList)
    {
        //
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
