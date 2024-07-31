<?php

namespace Tests\Unit\Task\Services;

use App\DTO\TaskDTO;
use App\Exceptions\Task\TaskCreatingException;
use App\Exceptions\Task\TaskDeletingException;
use App\Exceptions\Task\TaskException;
use App\Exceptions\Task\TaskUpdatingException;
use App\Models\Task;
use App\Services\Task\TaskService;
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
        $task = Task::factory()->create();

        $taskService = new TaskService();

        $updateData = new TaskDTO(
            title: 'Updated Task',
            description: 'This is an updated test task',
            date: '2024-02-21',
            start_time: '10:00:00',
            end_time: '11:00:00',
            id: $task->id
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

    public function test_successful_delete_task(): void
    {
        $task = Task::factory()->create();

        $taskService = new TaskService();

        $taskService->delete($task->id);

        $this->assertDatabaseMissing('tasks', [
            'id' => $task->id
        ]);
    }

    public function test_unsuccessful_delete_when_task_not_exist(): void
    {
        $this->expectException(TaskDeletingException::class);
        $this->expectExceptionMessage('Task is not exist');
        $this->expectExceptionCode(404);

        $taskService = new TaskService();

        $taskService->delete(3);
    }

    public function test_get_task_by_id(): void
    {
        $task = Task::factory()->create();

        $taskService = new TaskService();

        $foundTask = $taskService->getById($task->id);

        $this->assertEquals($task->id, $foundTask->id);
    }

    public function test_get_task_by_id_when_task_not_exist(): void
    {
        $this->expectException(TaskException::class);
        $this->expectExceptionMessage('Task is not exist');
        $this->expectExceptionCode(404);

        $taskService = new TaskService();

        $taskService->getById(3);
    }
}
