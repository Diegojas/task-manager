<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Task;
use App\Models\User;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    protected function authenticate()
    {
        $token = $this->user->createToken('API Token')->plainTextToken;

        $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/json',
        ]);
    }

    public function test_tasks_can_be_retrieved()
    {
        $this->authenticate();
        $tasks = Task::factory()->count(5)->create(['user_id' => $this->user->id]);

        $response = $this->getJson('/api/tasks');

        $response->assertStatus(200)
                 ->assertJsonCount(5, 'data');
    }

    public function test_a_task_can_be_created()
    {
        $this->authenticate();
        $taskData = [
            'title' => 'New Task',
            'description' => 'Task Description',
            'status' => 'pending'
        ];

        $response = $this->postJson('/api/tasks', $taskData);

        $response->assertStatus(201);
        $this->assertDatabaseHas('tasks', $taskData);
    }

    public function test_a_task_can_be_updated()
    {
        $this->authenticate();
        $task = Task::factory()->create(['user_id' => $this->user->id]);

        $response = $this->putJson("/api/tasks/{$task->id}", [
            'title' => 'Updated Title',
            'status' => 'in_progress'
        ]);

        $response->assertStatus(200);
        $task->refresh();
        $this->assertEquals('Updated Title', $task->title);
    }

    public function test_a_task_can_be_deleted()
    {
        $this->authenticate();
        $task = Task::factory()->create(['user_id' => $this->user->id]);

        $response = $this->deleteJson("/api/tasks/{$task->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}
