<?php

namespace Domain\Recruitment\DataTransferObjects;

use Illuminate\Http\UploadedFile;
use Support\DataTransferObjects\DataTransferObject;

class SubmittedApplicationData extends DataTransferObject
{
    public function __construct(
        public readonly ApplicationData $application_data,
        public readonly UploadedFile $cv,
    ) {
        //
    }
}
