<?php

namespace App\Services\Task;

use App\DTO\TaskDTO;
use App\Exceptions\Task\TaskCreatingException;
use App\Exceptions\Task\TaskUpdatingException;
use App\Models\Task;
use Carbon\Carbon;

class TaskService
{

    /**
     * @throws TaskCreatingException
     */
    public function create(TaskDTO $taskDTO): Task
    {
        try {
            $task = new Task();
            $task->title = $taskDTO->title;
            $task->description = $taskDTO->description;
            $task->date = new Carbon($taskDTO->date);

            $task->setStartTime(
                Carbon::createFromFormat('H:i:s', $taskDTO->start_time)
            );
            $task->setEndTime(
                Carbon::createFromFormat('H:i:s', $taskDTO->end_time)
            );

            $task->save();

            return $task;
        } catch (\Exception $e) {
            throw new TaskCreatingException();
        }
    }

    /**
     * @throws TaskUpdatingException
     */
    public function update(TaskDTO $taskDTO): Task
    {
        $task = Task::where('id', $taskDTO->id)->first();

        if (!$task) {
            throw TaskUpdatingException::taskNotExist();
        }

        $task->fill($taskDTO->toArray());

        if ($taskDTO->date) {
            $task->date = new Carbon($taskDTO->date);
        }

        if ($taskDTO->start_time) {
            $task->setStartTime(
                Carbon::createFromFormat('H:i:s', $taskDTO->start_time)
            );
        }

        if ($taskDTO->end_time) {
            $task->setEndTime(
                Carbon::createFromFormat('H:i:s', $taskDTO->end_time)
            );
        }

        $task->save();

        return $task;
    }
}
