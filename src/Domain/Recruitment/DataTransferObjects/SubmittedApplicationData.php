<?php

namespace Domain\Recruitment\DataTransferObjects;

use Illuminate\Http\UploadedFile;

class SubmittedApplicationData
{
    public function __construct(
        public readonly ApplicationData $application_data,
        public readonly UploadedFile $cv,
    ) {
        //
    }

    public static function from(array $data): self
    {
        return new self(...$data);
    }
}
