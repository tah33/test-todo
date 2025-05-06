<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Service\TaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    protected $taskService;
    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }
    public function index(): JsonResponse
    {
        try {
            $tasks                  = $this->taskService->index();
            $data                   = [
                'tasks'             => TaskResource::collection($tasks),
                'success'           => true,
                'paginated_data'    => [
                    'rows'          => $tasks->total(),
                    'total'         => $tasks->total(),
                    'currentPage'   => $tasks->currentPage(),
                    'perPage'       => $tasks->perPage(),
                    'last_page'     => $tasks->lastPage(),
                    'next_page_url' => $tasks->nextPageUrl(),
                    'first_item'    => $tasks->firstItem(),
                ],
            ];
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(TaskRequest $request): JsonResponse
    {
        try {
            $this->taskService->store($request->all());
            return response()->json([
                'success' => true,
                'message' => 'Task created successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function show(Task $task)
    {
        try {
            return response()->json([
                'success' => true,
                'message' => 'Task created successfully',
                'task'    => $task,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    public function update(TaskRequest $request, Task $task): JsonResponse
    {
        try {
            $this->taskService->update($request->all(), $task);
            return response()->json([
                'success' => true,
                'message' => 'Task updated successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(Task $task)
    {
        try {
            $this->taskService->destroy($task->id);
            return response()->json([
                'success' => true,
                'message' => 'Task deleted successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    public function completeTask(Task $task)
    {
        try {
            $this->taskService->update(['is_completed' => true], $task);
            return response()->json([
                'success' => true,
                'message' => 'Task completed successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
