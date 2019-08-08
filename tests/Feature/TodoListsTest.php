<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TodoListsTest extends TestCase
{
    public function testGuestsCannotCreateTodoList()
    {
        $this->get('/lists')->assertRedirect('login');
        $this->post('/lists')->assertRedirect('login');
    }
}
