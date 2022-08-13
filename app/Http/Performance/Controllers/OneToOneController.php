<?php

namespace App\Http\Performance\Controllers;

use App\Http\Performance\Requests\OneToOneRequest;
use App\Http\Support\Controllers\Controller;
use Domain\Performance\Actions\CreateOneToOneAction;
use Domain\Performance\DataTransferObjects\OneToOneData;
use Illuminate\Http\RedirectResponse;

class OneToOneController extends Controller
{
    public function store(OneToOneRequest $request, CreateOneToOneAction $createOneToOne): RedirectResponse
    {
        $createOneToOne->execute(
            OneToOneData::from($request->validatedData())
        );

        return back()->with('flash.success', 'One-to-one requested!');
    }
}
