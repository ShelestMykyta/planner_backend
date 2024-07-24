<?php

namespace App\Http\Controllers;

use App\DTO\TaskDTO;
use App\Exceptions\Task\TaskCreatingException;
use App\Http\Requests\Task\CreateTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Services\Task\TaskService;

class TaskController extends Controller
{
    public function __construct(private readonly TaskService $taskService)
    {

    }

    /**
     * @throws TaskCreatingException
     */
    public function create(CreateTaskRequest $request): TaskResource
    {
        $taskDTO = new TaskDTO(
            title: $request->input('title'),
            description: $request->input('description'),
            date: $request->input('date'),
            start_time: $request->input('start_time'),
            end_time: $request->input('end_time')
        );

        $task = $this->taskService->create($taskDTO);

        return new TaskResource($task);
    }


    public function update(UpdateTaskRequest $request, int $id): TaskResource
    {
        $taskDTO = new TaskDTO(
            title: $request->input('title'),
            description: $request->input('description'),
            date: $request->input('date'),
            start_time: $request->input('start_time'),
            end_time: $request->input('end_time'),
            id: $id
        );

        $task = $this->taskService->update($taskDTO);

        return new TaskResource($task);
    }
}
