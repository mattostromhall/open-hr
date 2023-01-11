<?php

namespace Domain\Auth\Actions\Contracts;

use Domain\Auth\DataTransferObjects\ResetPasswordData;

interface ResetPasswordActionInterface
{
    public function execute(ResetPasswordData $data): mixed;
}
