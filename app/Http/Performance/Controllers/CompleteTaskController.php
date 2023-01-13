<?php

namespace App\Http\Performance\Controllers;

use App\Http\Support\Controllers\Controller;
use Domain\Performance\Actions\Contracts\CompleteTaskActionInterface;
use Domain\Performance\Models\Task;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CompleteTaskController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function __invoke(Request $request, Task $task, CompleteTaskActionInterface $completeTask): RedirectResponse
    {
        $this->authorize('complete', $task);

        $completed = $completeTask->execute($task);

        if (! $completed) {
            return back()->with('flash.error', 'There was a problem with completing the Task, please try again.');
        }

        return back()->with('flash.success', 'Task marked as complete!');
    }
}
