<?php

namespace Domain\Organisation\DataTransferObjects;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Support\DataTransferObjects\DataTransferObject;

class OrganisationData extends DataTransferObject
{
    public function __construct(
        public readonly string $name,
        public readonly ?UploadedFile $logo,
        public readonly ?Carbon $setup_at = null
    ) {
        //
    }
}
