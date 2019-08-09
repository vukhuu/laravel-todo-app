<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Repositories\TodoListRepository;

class TodoListRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function testcreateWithItems()
    {
        $user = factory(\App\User::class)->create();
        $this->be($user);

        $listAttributes = factory(\App\TodoList::class)->raw();
        $itemAttributes = factory(\App\TodoListItem::class)->raw();

        $repo = app()->make('App\Repositories\Contracts\TodoListRepositoryInterface');
        $repo->createWithItems($listAttributes, [$itemAttributes]);
        $this->assertDatabaseHas('todo_lists', $listAttributes);
    }
}
