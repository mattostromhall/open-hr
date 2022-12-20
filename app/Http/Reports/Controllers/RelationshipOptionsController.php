<?php

namespace App\Http\Reports\Controllers;

use App\Http\Support\Controllers\Controller;
use Illuminate\Database\Eloquent\Collection;
use Support\Models\Report;

class RelationshipOptionsController extends Controller
{
    public function __invoke(string $model): Collection
    {
        $FQCN = Report::FQCN($model);

        return $FQCN::all();
    }
}
