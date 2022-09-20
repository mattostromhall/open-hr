<?php

namespace Support\Contracts;

use Domain\People\Models\Person;
use Support\Enums\Action;

interface ActionableEvent
{
    public function person(): Person;

    public function action(): Action;

    public function payload(): string;

    public function actionableId(): int;

    public function actionableType(): string;
}
