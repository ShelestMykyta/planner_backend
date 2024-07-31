<?php

namespace App\Services\Task;

use App\DTO\TaskDTO;
use App\Exceptions\Task\TaskCreatingException;
use App\Exceptions\Task\TaskDeletingException;
use App\Exceptions\Task\TaskException;
use App\Exceptions\Task\TaskUpdatingException;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

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

    /**
     * @throws TaskDeletingException
     */
    public function delete(int $id): void
    {
        $task = Task::where('id', $id)->first();

        if (!$task) {
            throw TaskDeletingException::taskNotExist();
        }

        $task->delete();
    }

    public function getById(int $id): Task
    {
        $task = Task::find($id);

        if (!$task) {
            throw TaskException::taskNotExist();
        }

        return $task;
    }

    public function getAll(): Collection
    {
        return Task::all();
    }
}
