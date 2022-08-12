<?php

namespace App\Http\Performance\Controllers;

use App\Http\Support\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class OneToOneController extends Controller
{
    public function store(): RedirectResponse
    {
        return back()->with('flash.success', 'One-to-one requested!');
    }
}
