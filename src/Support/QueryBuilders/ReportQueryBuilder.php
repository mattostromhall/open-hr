<?php

namespace Support\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection as SupportCollection;
use Support\DataTransferObjects\ReportConditionData;
use Support\DataTransferObjects\ReportConditionGroupData;
use Support\DataTransferObjects\ReportData;

class ReportQueryBuilder
{
    protected ?Builder $builder;

    public static function build(ReportData $reportData): self
    {
        return (new self())
            ->for($reportData->model)
            ->scaffold($reportData->conditionGroups);
    }

    public function for(Model $model): self
    {
        $this->builder = $model->query();

        return $this;
    }

    /**
     * @param SupportCollection<ReportConditionGroupData> $conditionGroups
     * @return ReportQueryBuilder
     */
    public function scaffold(SupportCollection $conditionGroups): self
    {
        $conditionGroups->each(
            fn (ReportConditionGroupData $conditionGroup) =>
            $this->addConditionGroup($conditionGroup)
        );

        return $this;
    }

    public function addConditionGroup(ReportConditionGroupData $conditionGroup): self
    {
        if ($conditionGroup->type === 'and') {
            $this->addWhereConditionGroup($conditionGroup);
        }

        if ($conditionGroup->type === 'or') {
            $this->addOrWhereConditionGroup($conditionGroup);
        }

        return $this;
    }

    public function addWhereConditionGroup(ReportConditionGroupData $conditionGroup): self
    {
        $this->builder->where(
            fn (Builder $builder) =>
            $conditionGroup->conditions->each(
                fn (ReportConditionData $condition) =>
                $this->addWhereClause($builder, $condition)
            )
        );

        return $this;
    }

    public function addOrWhereConditionGroup(ReportConditionGroupData $conditionGroup): self
    {
        $this->builder->orWhere(
            fn (Builder $builder) =>
            $conditionGroup->conditions->each(
                fn (ReportConditionData $condition) =>
                $this->addWhereClause($builder, $condition)
            )
        );

        return $this;
    }

    public function addWhereClause(Builder $builder, ReportConditionData $condition): self
    {
        $builder->where($condition->column, $condition->operator, $condition->value);

        return $this;
    }

    public function run(): Collection | array
    {
        return $this->builder->get();
    }
}
