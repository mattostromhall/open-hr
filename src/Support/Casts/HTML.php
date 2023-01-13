<?php

namespace Support\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Support\Actions\Contracts\StripScriptTagsActionInterface;

class HTML implements CastsAttributes
{
    public function get($model, string $key, mixed $value, array $attributes): string
    {
        return app(StripScriptTagsActionInterface::class)->execute($value);
    }

    public function set($model, string $key, mixed $value, array $attributes): string
    {
        return app(StripScriptTagsActionInterface::class)->execute($value);
    }
}
