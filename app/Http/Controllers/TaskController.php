<?php

namespace App\Http\Controllers;

use App\DTO\TaskDTO;
use App\Exceptions\Task\TaskCreatingException;
use App\Exceptions\Task\TaskDeletingException;
use App\Exceptions\Task\TaskException;
use App\Exceptions\Task\TaskUpdatingException;
use App\Http\Requests\Task\CreateTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Services\Task\TaskService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

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


    /**
     * @throws TaskUpdatingException
     */
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

    /**
     * @throws TaskDeletingException
     */
    public function delete(int $id): Response
    {
        $this->taskService->delete($id);

        return response()->noContent();
    }

    /**
     * @throws TaskException
     */
    public function get(int $id): TaskResource
    {
        $task = $this->taskService->getById($id);

        return new TaskResource($task);
    }

    public function getAll(): AnonymousResourceCollection
    {
        $tasks = $this->taskService->getAll();

        return TaskResource::collection($tasks);
    }
}
