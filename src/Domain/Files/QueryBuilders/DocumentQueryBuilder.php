<?php

namespace Domain\Files\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;

class DocumentQueryBuilder extends Builder
{
    public function locatedAt(string $path): self
    {
        $identifier = Str::afterLast($path, '/');
        $name = Str::beforeLast($identifier, '.');
        $extension = Str::afterLast($identifier, '.');

        $directory = Str::of($path)
            ->beforeLast('/')
            ->when(! Str::startsWith($path, '/'), function (Stringable $string) {
                return $string->prepend('/');
            });

        return $this->where('name', $name)
            ->where('extension', $extension)
            ->where('directory', $directory);
    }

    public function inDirectory(string $directory): self
    {
        return $this->where('directory', $directory);
    }
}
