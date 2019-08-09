<?php

namespace App\Helpers\ActivityLogger;

use App\Helpers\ActivityLogger\Contracts\ActivityLoggerInterface;
use Illuminate\Support\Facades\Log;

class ActivityFileLogger implements ActivityLoggerInterface
{
    /**
     * {@inheritdoc}
     */
    public function log($activity, $id = null, $newValue = null, $byUserId = null)
    {
        if (empty($byUserId)) {
            $byUserId = auth()->id();
        }
        $args = compact('activity', 'id', 'newValue', 'byUserId');
        Log::info(implode('|||', $args));
    }
}