<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\TaskRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TaskController extends Controller
{

    private TaskRepositoryInterface $taskRepository;

    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function index(): JsonResponse
    {
        return response()->json($this->taskRepository->all());
    }

    public function show($id): JsonResponse
    {
        $task = $this->taskRepository->find($id);
        if (!$task) {
            return response()->json(['error' => 'Task not found'], 404);
        }
        return response()->json($task);
    }

    public function store(Request $request): JsonResponse
    {
        $task = $this->taskRepository->create($request->all());
        return response()->json([
            "message" => "Task created successfully",
            "task" => $task,
        ], 201);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $updated = $this->taskRepository->update($id, $request->all());
        if ($updated) {
            return response()->json([
                "message" => "Task updated successfully",
                'success' => $updated
            ]);
        }
        return response()->json([
            "message" => "Task does not exist",
            'success' => $updated
        ], 404);
    }

    public function destroy($id): JsonResponse
    {
        $deleted = $this->taskRepository->delete($id);
        return response()->json(['success' => $deleted, "message" => "Task deleted successfully"]);
    }
}
