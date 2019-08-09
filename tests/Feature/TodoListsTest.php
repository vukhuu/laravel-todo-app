<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\TodoList;
use App\TodoListItem;

class TodoListsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function testGuestsCannotCreateTodoList()
    {
        $this->get(route('todoLists.index'))->assertRedirect('login');
        $this->post(route('todoLists.store'))->assertRedirect('login');
    }

    /**
     * Create a todo list
     * 
     * @return array \Illuminate\Http\JsonResponse
     */
    private function _createTodoList($listAttributes, $itemAttributes)
    {
        /* Construct JSON data as format [
            <todoListModelAttributes>
            'items' => [<todoListItemAttributes]
        ] */
        $data = $listAttributes;
        $data['items'] = [$itemAttributes];
        
        return $this->json('POST', route('todoLists.store'), $data);
    }

    public function testUserCreateTodoList()
    {
        $this->withoutExceptionHandling();
        $this->signIn();

        $listAttributes = factory(TodoList::class)->raw();
        $itemAttributes = factory(TodoListItem::class)->raw();

        $response = $this->_createTodoList($listAttributes, $itemAttributes);
        $response->assertStatus(201);

        $this->assertDatabaseHas('todo_lists', $listAttributes);
        $this->assertDatabaseHas('todo_list_items', $itemAttributes);
    }

    public function testUserUpdateTodoListTitle()
    {
        $this->signIn();
        
        // Create a todo list first
        $listAttributes = factory(TodoList::class)->raw();
        $itemAttributes = factory(TodoListItem::class)->raw();
        $response = $this->_createTodoList($listAttributes, $itemAttributes);
        $content = json_decode($response->getContent(), true);
        $listId = $content['id'];

        // Update its attributes
        $newAttributes = factory(TodoList::class)->raw();

        $url = route('todoLists.update', ['todoList' => $listId]);
        $response = $this->json('PUT', $url, ['title' => $newAttributes['title']]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('todo_lists', ['id' => $listId, 'title' => $newAttributes['title']]);
    }

    public function testUserDeleteTodoList()
    {
        $this->withoutExceptionHandling();
        $this->signIn();
        
        // Create a todo list first
        $listAttributes = factory(TodoList::class)->raw();
        $itemAttributes = factory(TodoListItem::class)->raw();
        $response = $this->_createTodoList($listAttributes, $itemAttributes);
        $content = json_decode($response->getContent(), true);
        $listId = $content['id'];

        // Destroy model
        $url = route('todoLists.destroy', ['todoList' => $listId]);
        $response = $this->json('DELETE', $url);
        $response->assertStatus(200);
        $deleteModel = TodoList::withTrashed()->find($listId);
        $this->assertTrue(!empty($deleteModel->deleted_at));
    }
}
