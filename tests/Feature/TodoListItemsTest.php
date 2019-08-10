<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\TodoList;
use App\TodoListItem;

class TodoListItemsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function testCreateTodoListItem()
    {
        $this->signIn();
        
        // Create a todo list first
        $listAttributes = factory(TodoList::class)->raw();
        $itemAttributes = factory(TodoListItem::class)->raw();
        $response = $this->createTodoList($listAttributes, $itemAttributes);
        $content = json_decode($response->getContent(), true);
        $listId = $content['id'];

        $url = route('todoListItems.store');
        $attributes = factory(TodoListItem::class)->raw();
        $attributes['todo_list_id'] = $listId;
        $response = $this->json('POST', $url, $attributes);
        $response->assertStatus(201);
        $content = json_decode($response->getContent(), true);

        $this->assertDatabaseHas('todo_list_items', [
            'id' => $content['id'],
            'name' => $attributes['name'],
        ]);
    }

    public function testUpdateTodoListItem()
    {
        $this->signIn();
        
        // Create a todo list first
        $listAttributes = factory(TodoList::class)->raw();
        $itemAttributes = factory(TodoListItem::class)->raw();
        $response = $this->createTodoList($listAttributes, $itemAttributes);
        $content = json_decode($response->getContent(), true);
        
        $firstTodoItem = $content['todo_list_items'][0];

        $url = route('todoListItems.update', ['todoListItem' => $firstTodoItem['id']]);
        $attributes = factory(TodoListItem::class)->raw();
        $response = $this->json('PUT', $url, $attributes);
        $response->assertStatus(200);

        $this->assertDatabaseHas('todo_list_items', [
            'id' => $firstTodoItem['id'],
            'name' => $attributes['name'],
        ]);
    }

    public function testDeleteTodoListItem()
    {
        $this->signIn();
        
        // Create a todo list first
        $listAttributes = factory(TodoList::class)->raw();
        $itemAttributes = factory(TodoListItem::class)->raw();
        $response = $this->createTodoList($listAttributes, $itemAttributes);
        $content = json_decode($response->getContent(), true);
        
        $firstTodoItem = $content['todo_list_items'][0];

        $url = route('todoListItems.destroy', ['todoListItem' => $firstTodoItem['id']]);
        $response = $this->json('DELETE', $url);
        $response->assertStatus(200);
        $deleteModel = TodoListItem::withTrashed()->find($firstTodoItem['id']);
        $this->assertTrue(!empty($deleteModel->deleted_at));
    }

    public function testMarkDoneTodoListItem()
    {
        $this->withoutExceptionHandling();
        $this->signIn();
        
        // Create a todo list first
        $listAttributes = factory(TodoList::class)->raw();
        $itemAttributes = factory(TodoListItem::class)->raw();
        $response = $this->createTodoList($listAttributes, $itemAttributes);
        $content = json_decode($response->getContent(), true);
        
        $firstTodoItem = $content['todo_list_items'][0];

        $url = route('todoListItems.markDone', ['todoListItem' => $firstTodoItem['id']]);
        $response = $this->json('POST', $url);
        $response->assertStatus(200);
        $model = TodoListItem::find($firstTodoItem['id']);
        $this->assertTrue($model->is_done == 1);
    }
}
