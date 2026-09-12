<?php

namespace App\Http\Controllers;

use App\Enums\TaskStatus;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $request->validate([
            'status' => ['sometimes', Rule::in(['all', TaskStatus::Pending->value, TaskStatus::Completed->value])],
            'search' => ['sometimes', 'string', 'max:255'],
        ]);

        $status = $request->query('status', 'all');
        $search = $request->query('search');

        $tasks = Task::query()
            ->when($status !== 'all', fn ($query) => $query->where('status', $status))
            ->when($search, fn ($query) => $query->where('title', 'like', '%'.$search.'%'))
            ->latest()
            ->paginate()
            ->withQueryString();

        return TaskResource::collection($tasks)
            ->additional([
                'success' => true,
                'message' => 'Tasks retrieved successfully.',
            ])
            ->response();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request): JsonResponse
    {
        $task = Task::create($request->validated());

        return ApiResponse::success(
            TaskResource::make($task),
            'Task created successfully.',
            201,
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task): JsonResponse
    {
        return ApiResponse::success(
            TaskResource::make($task),
            'Task retrieved successfully.',
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task): JsonResponse
    {
        $task->update($request->validated());

        return ApiResponse::success(
            TaskResource::make($task),
            'Task updated successfully.',
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task): JsonResponse
    {
        $task->delete();

        return ApiResponse::success(
            message: 'Task deleted successfully.',
        );
    }
}
