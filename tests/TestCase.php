<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Sign in using default user
     */
    protected function signIn()
    {
        $this->actingAs(factory('App\User')->create());
    }

    /**
     * Create a todo list
     * 
     * @return array \Illuminate\Http\JsonResponse
     */
    protected function createTodoList($listAttributes, $itemAttributes)
    {
        /* Construct JSON data as format [
            <todoListModelAttributes>
            'items' => [<todoListItemAttributes]
        ] */
        $data = $listAttributes;
        $data['todo_list_items'] = [$itemAttributes];
        
        return $this->json('POST', route('todoLists.store'), $data);
    }
}
