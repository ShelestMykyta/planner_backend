<?php

namespace Tests\Unit;

use App\Exceptions\Task\ErrorTaskCreatingException;
use App\Exceptions\Task\ErrorTaskUpdatingException;
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

        $preparedData = [
            'title' => 'Test Task',
            'description' => 'This is a test task',
            'date' => '2024-02-20',
            'start_time' => '09:00:00',
            'end_time' =>  '10:00:00'
        ];

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
        $this->expectException(ErrorTaskCreatingException::class);

        $taskService = new TaskService();

        $preparedData = [
            'title' => 'Test Task',
            'date' => '2024-02-20',
            'start_time' => '09:00:00',
            'end_time' =>  '08:00:00'
        ];

        $taskService->create($preparedData);
    }

    public function test_successful_update_task(): void
    {
        $task = new Task();
        $task->title = 'Test Task';
        $task->description = 'This is a test task';
        $task->date = Carbon::create(2024, 2, 20);
        $task->setStartTime( Carbon::createFromFormat('H:i:s', '09:00:00'));
        $task->setEndTime( Carbon::createFromFormat('H:i:s', '10:00:00'));
        $task->save();

        $taskService = new TaskService();
        $updatedTask = $taskService->update([
            'id' => 2,
            'title' => 'Updated Task',
            'description' => 'This is an updated test task',
            'date' => '2024-02-21',
            'start_time' => '10:00:00',
            'end_time' =>  '11:00:00'
        ]);

        $this->assertDatabaseHas('tasks', [
            'title' => 'Updated Task',
            'description' => 'This is an updated test task',
            'date' => '2024-02-21',
            'start_time' => '10:00:00',
            'end_time' => '11:00:00'
        ]);
    }

    public function test_unsuccessful_update_task_with_exception(): void
    {
        $task = new Task();
        $task->title = 'Test Task';
        $task->description = 'This is a test task';
        $task->date = Carbon::create(2024, 2, 20);
        $task->setStartTime( Carbon::createFromFormat('H:i:s', '09:00:00'));
        $task->setEndTime( Carbon::createFromFormat('H:i:s', '10:00:00'));
        $task->save();

        $this->expectException(ErrorTaskUpdatingException::class);

        $taskService = new TaskService();
        $updatedTask = $taskService->update([
            'id' => 3,
            'title' => 'Updated Task',
            'start_time' => '10:00:00',
            'end_time' =>  '08:00:00'
        ]);
    }
}
