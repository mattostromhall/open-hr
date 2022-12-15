<?php

namespace Support\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;
use Support\Contracts\Services\ReportBuilderInterface;
use Support\DataTransferObjects\ReportConditionData;
use Support\DataTransferObjects\ReportConditionSetData;
use Support\DataTransferObjects\ReportData;

class ReportBuilder implements ReportBuilderInterface
{
    protected ?Builder $builder;

    public static function build(ReportData $reportData): self
    {
        return (new self())
            ->for($reportData->model)
            ->scaffold($reportData->condition_sets);
    }

    public function for(string $model): self
    {
        $this->builder = $model::query();

        return $this;
    }

    /**
     * @param SupportCollection<ReportConditionSetData> $conditionSets
     * @return ReportBuilder
     */
    public function scaffold(SupportCollection $conditionSets): self
    {
        $conditionSets->each(
            fn (ReportConditionSetData $conditionSet) =>
            $this->addConditionSet($conditionSet)
        );

        return $this;
    }

    public function addConditionSet(ReportConditionSetData $conditionSet): self
    {
        if ($conditionSet->type === 'and') {
            $this->addWhereConditionGroup($conditionSet);
        }

        if ($conditionSet->type === 'or') {
            $this->addOrWhereConditionGroup($conditionSet);
        }

        return $this;
    }

    public function addWhereConditionGroup(ReportConditionSetData $conditionSet): self
    {
        $this->builder->where(
            fn (Builder $builder) =>
            $conditionSet->conditions->each(
                fn (ReportConditionData $condition) =>
                $this->addWhereClause($condition, $builder)
            )
        );

        return $this;
    }

    public function addOrWhereConditionGroup(ReportConditionSetData $conditionSet): self
    {
        $this->builder->orWhere(
            fn (Builder $builder) =>
            $conditionSet->conditions->each(
                fn (ReportConditionData $condition) =>
                $this->addWhereClause($condition, $builder)
            )
        );

        return $this;
    }

    public function addWhereClause(ReportConditionData $condition, ?Builder $builder = null): self
    {
        if ($builder) {
            $builder->where($condition->column, $condition->operator, $condition->value);

            return $this;
        }

        $this->builder->where($condition->column, $condition->operator, $condition->value);

        return $this;
    }

    public function run(): Collection
    {
        return $this->builder->get();
    }

    public function sql()
    {
        return $this->builder->toSql();
    }
}
