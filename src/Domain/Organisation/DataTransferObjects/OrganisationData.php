<?php

namespace Domain\Organisation\DataTransferObjects;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;

class OrganisationData
{
    public function __construct(
        public readonly string $name,
        public readonly UploadedFile|string $logo,
        public readonly ?Carbon $setup_at = null
    ) {
        //
    }

    public static function from(array $data): self
    {
        return new self(...$data);
    }
}
