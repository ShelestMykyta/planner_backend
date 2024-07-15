<?php

namespace Tests\Feature\Task\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Throwable;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_task_endpoint_success_create(): void
    {
        $response = $this->post('/api/tasks', [
            'title' => 'Test Task',
            'description' => 'This is a test task',
            'date' => '2024-02-20',
            'start_time' => '09:00:00',
            'end_time' => '10:00:00'
        ]);

        $response->assertStatus(201);
    }

    public function test_create_task_endpoint_fail_create(): void
    {
        $response = $this->post('/api/tasks', [
            'title' => 'Test Task',
            'date' => '2024-02-20',
            'start_time' => '09:00:00',
            'end_time' => '08:00:00'
        ]);

        $response->assertStatus(422);
    }

    /**
     * @throws Throwable
     */
    public function test_create_task_endpoint_with_frong_time(): void
    {
        $response = $this->post('/api/tasks', [
            'title' => 'Test Task',
            'description' => 'This is a test task',
            'date' => '2024-02-20',
            'start_time' => '09:00:00',
            'end_time' => '08:00:00'
        ]);

        $data = $response->json();

        $this->assertEquals(
            "The start time must be earlier than the end time.",
            $data["details"]["start_time"][0]
        );
        $response->assertStatus(422);
    }
}
