<?php

namespace App\Http\Controllers;

use App\Helpers\DateHelper;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
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

    public function index(Request $request): JsonResponse
    {
        $dueDate = $request->get('due_date');
        $startDate = $dueDate ?: $request->get('due_start_date');
        $endDate = $dueDate ?: $request->get('due_end_date');
        $status = $request->get('status');

        return response()->json($this->taskRepository->all($startDate, $endDate, $status));
    }

    public function show($id): JsonResponse
    {
        $task = $this->taskRepository->find($id);
        if (!$task) {
            return response()->json(['error' => 'Task not found'], 404);
        }
        return response()->json($task);
    }

    public function store(StoreTaskRequest $request): JsonResponse
    {
        $dueDate = DateHelper::formatDate($request->get('due_date'));

        $data = [
            ...$request->all(),
            "created_at" => now(),
            "updated_at" => now(),
            "due_date" => $dueDate
        ];

        $task = $this->taskRepository->create($data);

        return response()->json([
            "message" => "Task created successfully",
            "task" => $task,
        ], 201);
    }

    public function update(UpdateTaskRequest $request, $id): JsonResponse
    {

        $dueDate = DateHelper::formatDate($request->get('due_date'));

        $data = [
            ...$request->all(),
            "updated_at" => now(),
            "due_date" => $dueDate
        ];

        $updated = $this->taskRepository->update($id, $data);

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
