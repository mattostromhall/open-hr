<?php

namespace Domain\Files\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;

class DocumentQueryBuilder extends Builder
{
    public function wherePath(string $path): self
    {
        $name = Str::afterLast($path, '/');
        $path = Str::of($path)
            ->beforeLast('/')
            ->when(! Str::startsWith($path, '/'), function (Stringable $string) {
                return $string->prepend('/');
            });

        return $this->where('name', $name)
            ->where('path', $path);
    }
}
