<?php

namespace Tests\Unit\Task\Services;

use App\DTO\TaskDTO;
use App\Exceptions\Task\TaskCreatingException;
use App\Exceptions\Task\TaskUpdatingException;
use App\Models\Task;
use App\Services\Task\TaskService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_successful_create_task(): void
    {
        $taskService = new TaskService();

        $preparedData = new TaskDTO(
            title: 'Test Task',
            description: 'This is a test task',
            date: '2024-02-20',
            start_time: '09:00:00',
            end_time: '10:00:00'
        );

        $task = $taskService->create($preparedData);

        $this->assertDatabaseHas('tasks', [
            'title' => 'Test Task',
            'description' => 'This is a test task',
            'date' => '2024-02-20',
            'start_time' => '09:00:00',
            'end_time' => '10:00:00'
        ]);
    }

    public function test_unsuccessful_create_task_with_exception(): void
    {
        $this->expectException(TaskCreatingException::class);

        $taskService = new TaskService();

        $preparedData = new TaskDTO(
            title: 'Test Task',
            description: 1,
            date: '2024-02-20',
            start_time: '09:00:00',
            end_time: '08:00:00'
        );

        $taskService->create($preparedData);
    }

    public function test_successful_update_task(): void
    {
        $task = new Task();
        $task->id = 2;
        $task->title = 'Test Task';
        $task->description = 'This is a test task';
        $task->date = Carbon::create(2024, 2, 20);
        $task->setStartTime( Carbon::createFromFormat('H:i:s', '09:00:00'));
        $task->setEndTime( Carbon::createFromFormat('H:i:s', '10:00:00'));
        $task->save();

        $taskService = new TaskService();

        $updateData = new TaskDTO(
            title: 'Updated Task',
            description: 'This is an updated test task',
            date: '2024-02-21',
            start_time: '10:00:00',
            end_time: '11:00:00',
            id: 2
        );

        $updatedTask = $taskService->update($updateData);

        $this->assertDatabaseHas('tasks', [
            'title' => 'Updated Task',
            'description' => 'This is an updated test task',
            'date' => '2024-02-21',
            'start_time' => '10:00:00',
            'end_time' => '11:00:00'
        ]);
    }

    public function test_unsuccessful_update_when_task_not_exist(): void
    {
        $this->expectException(TaskUpdatingException::class);
        $this->expectExceptionMessage('Task is not exist');
        $this->expectExceptionCode(404);

        $taskService = new TaskService();

        $updateTask = new TaskDTO(
            title: 'Updated Task',
            description: 123,
            date: '2024-02-21',
            start_time: '10:00:00',
            end_time: '11:00:00',
            id: 3
        );

        $updatedTask = $taskService->update($updateTask);
    }
}
