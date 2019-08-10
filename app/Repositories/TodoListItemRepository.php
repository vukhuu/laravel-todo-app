<?php

namespace App\Repositories;

use App\Repositories\Contracts\TodoListItemRepositoryInterface;
use App\TodoListItem;
use App\Helpers\ActivityLogger\Contracts\ActivityLoggerInterface;

class TodoListItemRepository implements TodoListItemRepositoryInterface
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
    public function create(array $attributes)
    {
        $model = TodoListItem::create($attributes);
        $this->activityLogger->log('todoListItem.create', $model->id);
        return $model;
    }

    /**
     * {@inheritdoc}
     */
    public function update(TodoListItem $todoListItem, array $newAttributes)
    {
        $todoListItem->fill($newAttributes);
        $updated = $todoListItem->save();
        if ($updated) {
            $this->activityLogger->log('todoListItem.update', $todoListItem->id,
                json_encode($todoListItem->getChanges()));
        }
        return $updated;
    }

    /**
     * {@inheritdoc}
     */
    public function destroy(TodoListItem $todoListItem)
    {
        $deleted = $todoListItem->delete();
        if ($deleted) {
            $this->activityLogger->log('todoListitem.destroy', $todoListItem->id);
        }
        return $deleted;
    }

    /**
     * {@inheritdoc}
     */
    public function markDone(TodoListItem $todoListItem)
    {
        $todoListItem->is_done = 1;
        $todoListItem->save();
        return $todoListItem;
    }
}