<?php

namespace App\Http\Performance\Controllers;

use App\Http\Support\Controllers\Controller;
use Domain\Performance\Actions\CompleteOneToOneAction;
use Domain\Performance\Models\OneToOne;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CompleteOneToOneController extends Controller
{
    public function __invoke(Request $request, OneToOne $oneToOne, CompleteOneToOneAction $completeOneToOne): RedirectResponse
    {
        $completed = $completeOneToOne->execute($oneToOne);

        if (! $completed) {
            return back()->with('flash.error', 'There was a problem with completing the One-to-one, please try again.');
        }

        return back()->with('flash.success', 'One-to-one marked as complete!');
    }
}
