<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Task;
use App\Http\Resources\TaskResource;
use App\Http\Resources\TaskCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

/**
 * @group Task Management
 *
 * APIs for managing tasks
 */
class TaskController extends Controller
{
    /**
     * List all tasks for authenticated user
     *
     * @authenticated
     *
     * @response 200 scenario="when authenticated" [{
     *  "id": 1,
     *  "user_id": 1,
     *  "title": "Sample task",
     *  "description": "This is a sample task description.",
     *  "status": "pending",
     *  "created_at": "2021-01-01T00:00:00.000000Z",
     *  "updated_at": "2021-01-01T00:00:00.000000Z"
     * }]
     */
    public function index()
    {
        $tasks = Task::where('user_id', Auth::id())->get();

        return new TaskCollection($tasks);
    }

    /**
     * Get Statistics of Tasks
     * 
     * Fetch statistics related to the tasks of the authenticated user.
     *
     * @authenticated
     * 
     * @responseField tasks.totalTasks integer Total number of tasks the user has
     * @responseField tasks.pendingTasks integer Total number of tasks with 'pending' status
     * @responseField tasks.newTasks integer Number of newly created tasks in the past week
     * 
     * @response 200 scenario="when authenticated" {
     *  "tasks": {
     *      "totalTasks": 10,
     *      "pendingTasks": 5,
     *      "newTasks": 2,
     *      "completedTask": 0
     *  }
     * }
     */
    public function stats()
    {
        $user = Auth::user();
        $totalTasks = $user->tasks()->count();
        $pendingTasks = $user->tasks()->where('status', 'pending')->count();
        $newTasks = $user->tasks()->where('status', 'new')->count();
        $completedTasks = $user->tasks()->where('status', 'completed')->count();

        return response()->json([
            'tasks' => [
                'totalTasks' => $totalTasks,
                'pendingTasks' => $pendingTasks,
                'newTasks' => $newTasks,
                'completedTasks' => $completedTasks
            ],
        ]);
    }

    /**
     * Create a new task for authenticated user
     *
     * @authenticated
     *
     * @bodyParam title string required The title of the task. Example: Finish homework
     * @bodyParam description string The description of the task. Example: Math, Literature and Sciences
     * @bodyParam status string The status of the task. Example: pending
     *
     * @response 201 scenario="success" {
     *  "id": 1,
     *  "user_id": 1,
     *  "title": "Finish homework",
     *  "description": "Math, Literature and Sciences",
     *  "status": "pending",
     *  "created_at": "2021-01-01T00:00:00.000000Z",
     *  "updated_at": "2021-01-01T00:00:00.000000Z"
     * }
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'description' => 'string|nullable',
            'status' => 'required|string'
        ]);

        $validatedData['user_id'] = Auth::id();

        $task = Task::create($validatedData);

        return new TaskResource($task);
    }

    /**
     * Get a specific task by ID for authenticated user
     *
     * @authenticated
     *
     * @urlParam task required The ID of the task. Example: 1
     *
     * @response 200 scenario="success" {
     *  "id": 1,
     *  "user_id": 1,
     *  "title": "Finish homework",
     *  "description": "Math, Literature and Sciences",
     *  "status": "pending",
     *  "created_at": "2021-01-01T00:00:00.000000Z",
     *  "updated_at": "2021-01-01T00:00:00.000000Z"
     * }
     */
    public function show(Task $task)
    {
        if (Auth::id() !== $task->user_id) {
            abort(403, 'Unauthorized action.');
        }

        return new TaskResource($task);
    }

    /**
     * Update a specific task
     *
     * @authenticated
     *
     * @urlParam task required The ID of the task. Example: 1
     * @bodyParam title string required The new title of the task. Example: Finish homework updated
     * @bodyParam description string The new description of the task. Example: Just Literature
     * @bodyParam status string The new status of the task. Example: completed
     *
     * @response 200 scenario="success" {
     *  "id": 1,
     *  "user_id": 1,
     *  "title": "Finish homework updated",
     *  "description": "Just Literature",
     *  "status": "completed",
     *  "created_at": "2021-01-01T00:00:00.000000Z",
     *  "updated_at": "2021-01-01T00:00:00.000000Z"
     * }
     */
    public function update(Request $request, Task $task)
    {
        if (Auth::id() !== $task->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $validatedData = $request->validate([
            'title' => 'sometimes|required|max:255',
            'description' => 'sometimes|nullable|string',
            'status' => 'required|string'
        ]);

        $task->update($validatedData);

        return new TaskResource($task);
    }

    /**
     * Delete a specific task
     *
     * @authenticated
     *
     * @urlParam task required The ID of the task that needs to be deleted. Example: 1
     *
     * @response 200 scenario="success" {}
     */
    public function destroy(Task $task)
    {
        if (Auth::id() !== $task->user_id) {
            abort(403, 'Unauthorized action.');
        }
        
        $task->delete();

        return response()->json(null, 200);
    }
}
