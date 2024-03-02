<?php

namespace App\Http\Controllers;

use App\Exceptions\Task\ErrorTaskCreatingException;
use App\Http\Requests\CreateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Services\Task\TaskService;
use Illuminate\Http\JsonResponse;

class TaskController extends Controller
{
    public function __construct(private TaskService $taskService)
    {

    }

    public function create(CreateTaskRequest $request): TaskResource|JsonResponse
    {
        try {
            $taskData = $request->all();
            $task = $this->taskService->create($taskData);
            return new TaskResource($task);
        } catch (ErrorTaskCreatingException $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
