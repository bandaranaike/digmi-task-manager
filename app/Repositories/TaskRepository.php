<?php

namespace App\Repositories;

use App\Repositories\Interfaces\TaskRepositoryInterface;
use Google\Cloud\Firestore\DocumentReference;
use Google\Cloud\Firestore\FirestoreClient;
use Kreait\Firebase\Factory;

class TaskRepository implements TaskRepositoryInterface
{
    const COLLECTION_NAME = 'tasks';
    protected FirestoreClient $firestore;

    public function __construct()
    {
        $factory = (new Factory)
            ->withServiceAccount(storage_path('app/firebase-credentials.json'));
        $this->firestore = $factory->createFirestore()->database();

    }

    public function all(): array
    {
        return array_map(function ($snapshot) {
            return [...$snapshot->data(), "id" => $snapshot->id()];
        }, $this->firestore->collection(self::COLLECTION_NAME)->documents()->rows());
    }

    public function find($id): array
    {
        return $this->firestore->collection(self::COLLECTION_NAME)->document($id)->snapshot()->data();
    }

    public function create($data): DocumentReference
    {
        return $this->firestore->collection(self::COLLECTION_NAME)->add($data);
    }

    public function update($id, $data): array
    {
        return $this->firestore->collection(self::COLLECTION_NAME)->document($id)->set($data, ['merge' => true]);
    }

    public function delete($id): array
    {
        return $this->firestore->collection(self::COLLECTION_NAME)->document($id)->delete();
    }
}
