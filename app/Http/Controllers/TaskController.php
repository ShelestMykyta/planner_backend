<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Services\Task\TaskService;

class TaskController extends Controller
{
    public function __construct(private TaskService $taskService)
    {

    }

    public function create(CreateTaskRequest $request): TaskResource
    {
        $taskData = $request->all();
        $task = $this->taskService->create($taskData);

        return new TaskResource($task);
    }
}
