<?php

namespace Tests\Unit\Task\Models;

use App\Exceptions\Task\TaskTimeException;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_task(): void
    {
        $task = new Task();
        $task->title = 'Test Task';
        $task->description = 'This is a test task';
        $task->date = Carbon::create(2024, 2, 20);
        $task->save();

        $this->assertDatabaseHas('tasks', [
            'title' => 'Test Task',
            'description' => 'This is a test task',
            'date' => '2024-02-20'
        ]);
    }

    public function test_create_task_with_start_and_finish(): void
    {
        $task = new Task();
        $task->title = 'Test Task';
        $task->description = 'This is a test task';
        $task->date = Carbon::create(2024, 2, 20);
        $task->setStartTime( Carbon::createFromFormat('H:i:s', '09:00:00'));
        $task->setEndTime( Carbon::createFromFormat('H:i:s', '10:00:00'));
        $task->save();

        $this->assertDatabaseHas('tasks', [
            'title' => 'Test Task',
            'description' => 'This is a test task',
            'date' => '2024-02-20',
            'start_time' => '09:00:00',
            'end_time' => '10:00:00'
        ]);
    }

    public function test_create_task_with_start_and_wrong_finish(): void
    {
        $this->expectException(TaskTimeException::class);
        $this->expectExceptionMessage('Finish time must be after start time');

        $task = new Task();
        $task->title = 'Test Task';
        $task->description = 'This is a test task';
        $task->date = Carbon::create(2024, 2, 20);
        $task->setStartTime( Carbon::createFromFormat('H:i:s', '09:00:00'));
        $task->setEndTime( Carbon::createFromFormat('H:i:s', '08:00:00'));
        $task->save();
    }

    public function test_create_task_with_no_start_and__finish(): void
    {
        $this->expectException(TaskTimeException::class);
        $this->expectExceptionMessage('Finish time must be after start time');
        $this->expectExceptionCode(400);

        $task = new Task();
        $task->title = 'Test Task';
        $task->description = 'This is a test task';
        $task->date = Carbon::create(2024, 2, 20);
        $task->setEndTime( Carbon::createFromFormat('H:i:s', '08:00:00'));
        $task->save();
    }

    public function test_create_task_with_start_and_without_finish(): void
    {
        $this->expectException(TaskTimeException::class);
        $this->expectExceptionMessage('Wrong time input. No end time.');
        $this->expectExceptionCode(400);

        $task = new Task();
        $task->title = 'Test Task';
        $task->description = 'This is a test task';
        $task->date = Carbon::create(2024, 2, 20);
        $task->setStartTime( Carbon::createFromFormat('H:i:s', '09:00:00'));
        $task->save();
    }
}
