<?php

namespace App\Repositories\Interfaces;

use Google\Cloud\Firestore\QuerySnapshot;
use Illuminate\Support\Collection;

interface TaskRepositoryInterface
{
    public function all();
    public function find(int $id);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
}
