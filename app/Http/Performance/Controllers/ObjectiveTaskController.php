<?php

namespace App\Http\Performance\Controllers;

use App\Http\Performance\Requests\StoreObjectiveRequest;
use App\Http\Performance\Requests\StoreTaskRequest;
use App\Http\Performance\Requests\UpdateObjectiveRequest;
use App\Http\Performance\Requests\UpdateTaskRequest;
use App\Http\Performance\ViewModels\ObjectiveViewModel;
use App\Http\Support\Controllers\Controller;
use Domain\Performance\Actions\AmendObjectiveAction;
use Domain\Performance\Actions\AmendTaskAction;
use Domain\Performance\Actions\SetObjectiveAction;
use Domain\Performance\Actions\SetTaskAction;
use Domain\Performance\DataTransferObjects\ObjectiveData;
use Domain\Performance\DataTransferObjects\OneToOneData;
use Domain\Performance\DataTransferObjects\TaskData;
use Domain\Performance\Models\Objective;
use Domain\Performance\Models\Task;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ObjectiveTaskController extends Controller
{
    public function store(StoreTaskRequest $request, Objective $objective, SetTaskAction $setTask): RedirectResponse
    {
        $setTask->execute(
            TaskData::from($request->validatedData())
        );

        return redirect(route('objective.show', ['objective' => $objective]))
            ->with('flash.success', 'Task successfully created!');
    }

    public function edit(Objective $objective): Response
    {
        return Inertia::render('Performance/Objectives/Edit', new ObjectiveViewModel($objective));
    }

    public function update(UpdateTaskRequest $request, Task $task, AmendTaskAction $amendTask): RedirectResponse
    {
        $taskData = TaskData::from([
            ...$task->only('description', 'due_at', 'completed_at'),
            ...$request->filteredValidatedData()
        ]);

        $updated = $amendTask->execute($task, $taskData);

        if (! $updated) {
            return back()->with('flash.error', 'There was a problem with updating the Task, please try again.');
        }

        return back()->with('flash.success', 'Task successfully updated!');
    }
}
