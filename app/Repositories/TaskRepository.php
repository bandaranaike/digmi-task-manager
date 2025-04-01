<?php

namespace App\Repositories;

use App\Repositories\Interfaces\TaskRepositoryInterface;
use Illuminate\Support\Collection;
use Kreait\Firebase\Factory;

class TaskRepository implements TaskRepositoryInterface
{
    protected $firestore;

    public function __construct()
    {
        $factory = (new Factory)
            ->withServiceAccount(storage_path('app/firebase-credentials.json'));
        $this->firestore = $factory->createFirestore()->database();

    }

    public function all(): Collection
    {
        return $this->firestore->collection('tasks')->documents();
    }

    public function find($id)
    {
        return $this->firestore->collection('tasks')->document($id)->snapshot();
    }

    public function create($data)
    {
        return $this->firestore->collection('tasks')->add($data);
    }

    public function update($id, $data)
    {
        return $this->firestore->collection('tasks')->document($id)->set($data, ['merge' => true]);
    }

    public function delete($id)
    {
        return $this->firestore->collection('tasks')->document($id)->delete();
    }
}
