<?php

namespace App\Repositories;

use App\Repositories\Interfaces\TaskRepositoryInterface;
use Kreait\Firebase\Factory;

class TaskRepository implements TaskRepositoryInterface
{
    const COLLECTION_NAME = 'tasks';
    protected $firestore;

    public function __construct()
    {
        $factory = (new Factory)
            ->withServiceAccount(storage_path('app/firebase-credentials.json'));
        $this->firestore = $factory->createFirestore()->database();

    }

    public function all()
    {
        return array_map(function ($snapshot) {
            return [...$snapshot->data(), "id" => $snapshot->id()];
        }, $this->firestore->collection(self::COLLECTION_NAME)->documents()->rows());
    }

    public function find($id)
    {
        return $this->firestore->collection(self::COLLECTION_NAME)->document($id)->snapshot()->data();
    }

    public function create($data)
    {
        return $this->firestore->collection(self::COLLECTION_NAME)->add($data);
    }

    public function update($id, $data)
    {
        return $this->firestore->collection(self::COLLECTION_NAME)->document($id)->set($data, ['merge' => true]);
    }

    public function delete($id)
    {
        return $this->firestore->collection(self::COLLECTION_NAME)->document($id)->delete();
    }
}
