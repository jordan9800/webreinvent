<?php

namespace App\Repositories\Interfaces;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface TaskRepositoryInterface
{
    public function all($attributes, Task $user): Collection;

    public function store($attributes = []): bool;

    public function markRead($attributes, Task $user): bool;
}
