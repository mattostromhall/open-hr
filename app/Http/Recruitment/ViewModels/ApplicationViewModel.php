<?php

namespace App\Http\Recruitment\ViewModels;

use App\Http\Support\ViewModels\ViewModel;
use Domain\Recruitment\Models\Application;

class ApplicationViewModel extends ViewModel
{
    public function __construct(protected Application $application)
    {
        //
    }

    public function application(): Application
    {
        return $this->application;
    }

    public function status()
    {
        return $this->application->status->statusDisplay();
    }

    public function vacancy(): array
    {
        return $this->application->vacancy->only('id', 'title');
    }

    public function cv()
    {
        return $this->application->cv;
    }
}
