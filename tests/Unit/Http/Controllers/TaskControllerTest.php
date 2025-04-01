<?php

namespace Tests\Unit\Http\Controllers;

use App\Http\Controllers\TaskController;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use Illuminate\Http\Request;
use Mockery;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    private  $taskRepositoryMock;
    private $taskController;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a mock for the TaskRepositoryInterface
        $this->taskRepositoryMock = Mockery::mock(TaskRepositoryInterface::class);

        // Instantiate the controller with the mocked repository
        $this->taskController = new TaskController($this->taskRepositoryMock);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testIndex()
    {
        $expectedResult = ['task1', 'task2'];

        $this->taskRepositoryMock
            ->shouldReceive('all')
            ->once()
            ->andReturn($expectedResult);

        $response = $this->taskController->index();

        $this->assertEquals(200, $response->status());
        $this->assertEquals(json_encode($expectedResult), $response->content());
    }

    public function testShow()
    {
        $taskId = 1;
        $expectedTask = ['id' => $taskId, 'name' => 'Test Task'];

        $this->taskRepositoryMock
            ->shouldReceive('find')
            ->with($taskId)
            ->once()
            ->andReturn($expectedTask);

        $response = $this->taskController->show($taskId);

        $this->assertEquals(200, $response->status());
        $this->assertEquals(json_encode($expectedTask), $response->content());
    }

    public function testStore()
    {
        $taskData = ['name' => 'New Task', 'description' => 'Task description'];
        $createdTask = ['id' => 1] + $taskData;

        $requestMock = Mockery::mock(Request::class);
        $requestMock->shouldReceive('all')->andReturn($taskData);

        $this->taskRepositoryMock
            ->shouldReceive('create')
            ->with($taskData)
            ->once()
            ->andReturn($createdTask);

        $response = $this->taskController->store($requestMock);

        $this->assertEquals(201, $response->status());
        $this->assertEquals(json_encode($createdTask), $response->content());
    }

    public function testUpdate()
    {
        $taskId = 1;
        $updateData = ['name' => 'Updated Task'];
        $requestMock = Mockery::mock(Request::class);
        $requestMock->shouldReceive('all')->andReturn($updateData);

        $this->taskRepositoryMock
            ->shouldReceive('update')
            ->with($taskId, $updateData)
            ->once()
            ->andReturn(true);

        $response = $this->taskController->update($requestMock, $taskId);

        $this->assertEquals(200, $response->status());
        $this->assertEquals(json_encode(['success' => true]), $response->content());
    }

    public function testDestroy()
    {
        $taskId = 1;

        $this->taskRepositoryMock
            ->shouldReceive('delete')
            ->with($taskId)
            ->once()
            ->andReturn(true);

        $response = $this->taskController->destroy($taskId);

        $this->assertEquals(200, $response->status());
        $this->assertEquals(json_encode(['success' => true]), $response->content());
    }

    public function testShowNotFound()
    {
        $taskId = 999;

        $this->taskRepositoryMock
            ->shouldReceive('find')
            ->with($taskId)
            ->once()
            ->andReturn(null);

        $response = $this->taskController->show($taskId);

        // Assert 404 status and optional error message
        $this->assertEquals(404, $response->status());
        $this->assertEquals(json_encode(['error' => 'Task not found']), $response->content());
    }

    public function testUpdateFailed()
    {
        $taskId = 1;
        $updateData = ['name' => 'Updated Task'];
        $requestMock = Mockery::mock(Request::class);
        $requestMock->shouldReceive('all')->andReturn($updateData);

        $this->taskRepositoryMock
            ->shouldReceive('update')
            ->with($taskId, $updateData)
            ->once()
            ->andReturn(false);

        $response = $this->taskController->update($requestMock, $taskId);

        $this->assertEquals(200, $response->status());
        $this->assertEquals(json_encode(['success' => false]), $response->content());
    }

    public function testDestroyFailed()
    {
        $taskId = 1;

        $this->taskRepositoryMock
            ->shouldReceive('delete')
            ->with($taskId)
            ->once()
            ->andReturn(false);

        $response = $this->taskController->destroy($taskId);

        $this->assertEquals(200, $response->status());
        $this->assertEquals(json_encode(['success' => false]), $response->content());
    }
}
