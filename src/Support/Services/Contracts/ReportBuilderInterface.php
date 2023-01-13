<?php

namespace Support\Services\Contracts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;
use Support\DataTransferObjects\ReportConditionData;
use Support\DataTransferObjects\ReportConditionSetData;
use Support\DataTransferObjects\ReportData;

interface ReportBuilderInterface
{
    public static function build(ReportData $reportData): self;

    public function for(string $model): self;

    /**
     * @param SupportCollection<ReportConditionSetData> $conditionSets
     * @return ReportBuilderInterface
     */
    public function scaffold(SupportCollection $conditionSets): self;

    public function addSelect(array $columns);

    public function addConditionSet(ReportConditionSetData $conditionSet): self;

    public function addWhereConditionGroup(ReportConditionSetData $conditionSet): self;

    public function addOrWhereConditionGroup(ReportConditionSetData $conditionSet): self;

    public function addWhereClause(ReportConditionData $condition, ?Builder $builder = null): self;

    public function run(): Collection;
}
