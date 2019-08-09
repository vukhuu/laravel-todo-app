<?php

namespace App\Repositories;

use App\Repositories\Contracts\TodoListRepositoryInterface;
use App\TodoList;
use App\TodoListItem;
use App\Helpers\ActivityLogger\Contracts\ActivityLoggerInterface;

class TodoListRepository implements TodoListRepositoryInterface
{
    /**
     * Logger for activities
     * 
     * @var ActivityLoggerInterface
     */
    protected $activityLogger;

    public function __construct(ActivityLoggerInterface $logger)
    {
        $this->activityLogger = $logger;
    }

    /**
     * {@inheritdoc}
     */
    public function createWithItems(array $listAttributes, array $items = [])
    {
        $list = TodoList::create($listAttributes);
        $this->activityLogger->log('todoList.create', $list->id);
        foreach ($items as $item) {
            $itemModel = $list->todoListItems()->create($item);
            $this->activityLogger->log('todoListItem.create', $itemModel->id);
        }

        return $list;
    }

    /**
     * {@inheritdoc}
     */
    public function update(TodoList $todoList, array $newAttributes)
    {
        $todoList->fill($newAttributes);
        $updated = $todoList->save();
        if ($updated) {
            $this->activityLogger->log('todoList.update', $todoList->id,
                json_encode($todoList->getChanges()));
        }
        return $updated;
    }

    /**
     * {@inheritdoc}
     */
    public function destroy(TodoList $todoList)
    {
        $deleted = $todoList->delete();
        if ($deleted) {
            $this->activityLogger->log('todoList.destroy', $todoList->id);
        }
        return $deleted;
    }
}