<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\TaskRepositoryInterface;
use Illuminate\Http\Request;

class TaskController extends Controller
{

    private TaskRepositoryInterface $taskRepository;

    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function index()
    {
        return response()->json($this->taskRepository->all());
    }

    public function show($id)
    {
        $task = $this->taskRepository->find($id);
        if (!$task) {
            return response()->json(['error' => 'Task not found'], 404);
        }
        return response()->json($task);
    }

    public function store(Request $request)
    {
        $task = $this->taskRepository->create($request->all());
        return response()->json($task, 201);
    }

    public function update(Request $request, $id)
    {
        $updated = $this->taskRepository->update($id, $request->all());
        return response()->json(['success' => $updated]);
    }

    public function destroy($id)
    {
        $deleted = $this->taskRepository->delete($id);
        return response()->json(['success' => $deleted]);
    }
}
