<?php

namespace App\Http\Performance\Controllers;

use App\Http\Performance\Requests\StoreTaskRequest;
use App\Http\Performance\Requests\UpdateTaskRequest;
use App\Http\Support\Controllers\Controller;
use Domain\Performance\Actions\Contracts\AmendTaskActionInterface;
use Domain\Performance\Actions\Contracts\SetTaskActionInterface;
use Domain\Performance\Actions\Contracts\UnsetTaskActionInterface;
use Domain\Performance\DataTransferObjects\TaskData;
use Domain\Performance\Models\Objective;
use Domain\Performance\Models\Task;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class ObjectiveTaskController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function store(StoreTaskRequest $request, Objective $objective, SetTaskActionInterface $setTask): RedirectResponse
    {
        $this->authorize('create', Task::class);

        DB::transaction(
            fn () => $setTask->execute($request->taskData())
        );

        return redirect(route('objective.show', ['objective' => $objective]))
            ->with('flash.success', 'Task successfully created!');
    }

    /**
     * @throws AuthorizationException
     */
    public function update(UpdateTaskRequest $request, Task $task, AmendTaskActionInterface $amendTask): RedirectResponse
    {
        $this->authorize('update', $task);

        $updated = DB::transaction(
            fn () => $amendTask->execute($task, $request->taskData())
        );

        if (! $updated) {
            return back()->with('flash.error', 'There was a problem with updating the Task, please try again.');
        }

        return back()->with('flash.success', 'Task successfully updated!');
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(Task $task, UnsetTaskActionInterface $unsetTask): RedirectResponse
    {
        $this->authorize('delete', $task);

        $deleted = DB::transaction(
            fn () => $unsetTask->execute($task, TaskData::from($task->toArray()))
        );

        if (! $deleted) {
            return back()->with('flash.error', 'There was a problem with unsetting the Task, please try again.');
        }

        return back()->with('flash.success', 'Task unset!');
    }
}
