<?php

namespace App\Http\Setup\Controllers;

use App\Http\HR\Requests\StoreHRRequest;
use App\Http\Support\Controllers\Controller;
use Domain\HR\Actions\CreateHRAction;
use Domain\HR\DataTransferObjects\HRData;
use Illuminate\Http\RedirectResponse;

class StoreHRController extends Controller
{
    public function __invoke(StoreHRRequest $request, CreateHRAction $createHR): RedirectResponse
    {
        $createHR->execute(
            HRData::from($request->validated())
        );

        return back();
    }
}
