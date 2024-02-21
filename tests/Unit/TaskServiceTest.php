<?php

namespace Tests\Unit;

use App\Exceptions\Task\ErrorTaskCreatingException;
use App\Services\Task\TaskService;
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
}
