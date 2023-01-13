<?php

namespace Support\Actions\Contracts;

interface StripScriptTagsActionInterface
{
    public function execute(?string $html): string;
}
