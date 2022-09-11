<?php

namespace App\Http\Performance\Controllers;

use App\Http\Support\Controllers\Controller;
use Domain\Performance\Actions\CompleteObjectiveAction;
use Domain\Performance\Actions\CompleteTaskAction;
use Domain\Performance\Models\Objective;
use Domain\Performance\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CompleteTaskController extends Controller
{
    public function __invoke(Request $request, Task $task, CompleteTaskAction $completeTask): RedirectResponse
    {
        $completed = $completeTask->execute($task);

        if (! $completed) {
            return back()->with('flash.error', 'There was a problem with completing the Task, please try again.');
        }

        return back()->with('flash.success', 'Task marked as complete!');
    }
}
