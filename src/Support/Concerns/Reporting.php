<?php

namespace Support\Concerns;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Support\DataTransferObjects\ReportableColumnData;

trait Reporting
{
    public static function reportableColumns(): Collection
    {
        $table = (new self())->getTable();

        return collect(Schema::getColumnListing($table))
            ->reject(
                fn (string $column) =>
                    $column === 'id'
                    || ($column !== 'person_id' && Str::endsWith($column, '_id'))
            )
            ->map(fn (string $column) => ReportableColumnData::from([
                'display' => self::formatDisplay($column),
                'column' => $column,
                'type' => self::mapColumnType($column, Schema::getColumnType($table, $column))
            ]))
            ->values();
    }

    protected static function formatDisplay(string $column): string
    {
        if ($column === 'person_id') {
            return 'Person';
        }

        return Str::of($column)
            ->replace('_', ' ')
            ->ucfirst()
            ->toString();
    }

    protected static function mapColumnType(string $column, string $databaseType): string
    {
        if ($column === 'person_id') {
            return 'relationship';
        }

        return collect([
            'string' => 'Text',
            'text' => 'TextArea',
            'datetime' => 'Date'
        ])->get($databaseType, $databaseType);
    }
}
