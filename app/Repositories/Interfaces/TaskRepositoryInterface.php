<?php

namespace App\Repositories\Interfaces;

use Google\Cloud\Firestore\DocumentReference;

interface TaskRepositoryInterface
{
    public function all($startDate = null, $endDate = null, $status = null): array;

    public function find(int $id): array;

    public function create(array $data): DocumentReference;

    public function update(int $id, array $data): array;

    public function delete(int $id): array;
}
