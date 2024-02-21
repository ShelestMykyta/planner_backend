<?php

namespace App\Services\Task;

use App\Exceptions\Task\ErrorTaskCreatingException;
use App\Models\Task;
use Carbon\Carbon;

class TaskService
{

    /**
     * @throws ErrorTaskCreatingException
     */
    public function create(array $taskData): Task
    {
        try {
            $task = new Task();

            $task->title = $taskData['title'];
            $task->description = $taskData['description'];
            $task->date = new Carbon($taskData['date']);

            $task->setStartTime(
                Carbon::createFromFormat('H:i:s', $taskData['start_time'])
            );
            $task->setEndTime(
                Carbon::createFromFormat('H:i:s', $taskData['end_time'])
            );

            $task->save();

            return $task;
        } catch (\Exception $e) {
            throw new ErrorTaskCreatingException();
        }
    }
}
