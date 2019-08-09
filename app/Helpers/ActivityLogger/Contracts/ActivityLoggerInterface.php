<?php

namespace App\Helpers\ActivityLogger\Contracts;

interface ActivityLoggerInterface
{
    /**
     * Log an action
     * 
     * @param  string  $activity  Type of the activity such as todoList.create
     * @param  int  $id  Id of the corresponding model
     * @param  string  $newValue  New value (if applicable)
     * @param  int  $byUserId  The user performing this action
     * 
     * @return void
     */
    public function log($activity, $id = null, $newValue = null, $byUserId = null);
}