<?php

namespace App\Services\Task;

use App\Exceptions\Task\ErrorTaskCreatingException;
use App\Exceptions\Task\ErrorTaskUpdatingException;
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

    /**
     * @throws ErrorTaskUpdatingException
     */
    public function update(array $taskData): Task
    {
        $task = Task::where('id', $taskData['id'])->first();

        if (!$task) {
            throw ErrorTaskUpdatingException::taskNotExist();
        }

        $task->fill($taskData);

        if ($taskData['start_time']) {
            $task->setStartTime(
                Carbon::createFromFormat('H:i:s', $taskData['start_time'])
            );
        }

        if ($taskData['end_time']) {
            $task->setEndTime(
                Carbon::createFromFormat('H:i:s', $taskData['end_time'])
            );
        }

        $task->save();

        return $task;
    }
}
