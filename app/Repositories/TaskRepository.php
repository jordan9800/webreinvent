<?php

namespace App\Repositories;

use App\Models\Task;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class TaskRepository implements TaskRepositoryInterface
{
    public function all($attributes, Task $user): Collection
    {
        $notifications = $user->notifications()
            ->when(isset($attributes['status']) && $attributes['status'] == 'read', function ($query) {
                $query->whereNotNull('read_At');
            })
            ->when(isset($attributes['status']) && $attributes['status'] == 'unread', function ($query) {
                $query->whereNull('read_At');
            })
            ->where('data->expiry_date', '>', date('Y-m-d'))
            ->orderByDesc('notifications.read_at')
            ->get();

        return $notifications;

    }

    public function store($attributes = []): bool
    {
        return true;
    }

    public function markRead($attributes, Task $user): bool
    {
        $notifications = $user->notifications()
            ->when(isset($attributes['notification_id']) && $attributes['notification_id'], function ($query) use ($attributes) {
                $query->where('id', $attributes['notification_id']);
            })->get();

        if ($notifications->isNotEmpty()) {
            $notifications->markAsRead();

            return true;
        }

        return false;
    }
}
