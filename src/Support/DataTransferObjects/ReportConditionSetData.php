<?php

namespace Support\DataTransferObjects;

use Illuminate\Support\Collection;

class ReportConditionSetData extends DataTransferObject
{
    /**
     * @param Collection<ReportConditionData> $conditions
     * @param string $type
     */
    public function __construct(
        public readonly Collection $conditions,
        public readonly string $type = 'and'
    ) {
        //
    }

    public static function fromArray(array $data): self
    {
        return new self(
            conditions: collect($data['conditions'])
                ->map(
                    fn (array $condition) =>
                    new ReportConditionData(
                        column: $condition['column'],
                        operator: $condition['operator'],
                        value: array_key_exists('value', $condition) ? $condition['value'] : null
                    )
                ),
            type: $data['type']
        );
    }
}
