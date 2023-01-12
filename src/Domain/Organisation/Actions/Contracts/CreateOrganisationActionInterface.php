<?php

namespace Domain\Organisation\Actions\Contracts;

use Domain\Organisation\DataTransferObjects\OrganisationData;
use Domain\Organisation\Models\Organisation;

interface CreateOrganisationActionInterface
{
    public function execute(OrganisationData $data): Organisation;
}
