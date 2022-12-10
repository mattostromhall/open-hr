<?php

namespace Support\Concerns;

use Illuminate\Support\Facades\Schema;

trait Reporting
{
    public static function reportableColumns(): array
    {
        $table = (new self())->getTable();
        return collect(Schema::getColumnListing($table))->map(fn (string $column) => [
            'column' => $column,
            'type' => Schema::getColumnType($table, $column)
        ])->toArray();
    }
}
