<?php

namespace App\Service;

use App\Models\Task;

class TaskService
{
    public function index()
    {
        return Task::where('user_id', auth()->id())->latest()->paginate(10);
    }

    public function store($data)
    {
        $data['user_id'] = auth()->id();
        return Task::create($data);
    }

    public function find($id)
    {
        return Task::find($id);
    }

    public function update($data, $task)
    {
        return $task->update($data);
    }

    public function destroy($id): int
    {
        return Task::destroy($id);
    }
}
