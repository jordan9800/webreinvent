<?php

namespace App\Repositories;

use App\Models\Task;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class TaskRepository implements TaskRepositoryInterface
{
    public function all($attributes = []): Collection
    {
        return Task::all();
    }

    public function get($id): ?Task
    {
        return Task::findOrFail($id);
    }

    public function store($attributes = []): bool
    {
        $success = Task::create([
            'name' => $attributes['name'],
        ]);

        return $success ? true : false;
    }

    public function update($id, $attributes = []): bool
    {
        $task = $this->get($id);
        $data = [
            'name' => $attributes['name'],
        ];

        if (isset($attributes['completed'])) {
            $data['completed'] = $attributes['completed'];
        }
        $success = $task->update($data);

        return $success ? true : false;
    }

    public function delete($id): Task|bool
    {
        $task = $this->get($id);
        $success = $task->delete();

        return $success ? true : false;
    }
}
