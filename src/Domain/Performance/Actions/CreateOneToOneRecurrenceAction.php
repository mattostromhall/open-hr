<?php

namespace Domain\Performance\Actions;

use Domain\Performance\Actions\Contracts\CreateOneToOneRecurrenceActionInterface;
use Domain\Performance\Actions\Contracts\ScheduleOneToOneActionInterface;
use Domain\Performance\DataTransferObjects\OneToOneData;
use Domain\Performance\Enums\OneToOneStatus;
use Domain\Performance\Enums\RecurrenceInterval;
use Domain\Performance\Models\OneToOne;
use Exception;
use Illuminate\Support\Carbon;

class CreateOneToOneRecurrenceAction implements CreateOneToOneRecurrenceActionInterface
{
    public function __construct(protected ScheduleOneToOneActionInterface $scheduleOneToOne)
    {
        //
    }

    /**
     * @throws Exception
     */
    public function execute(OneToOneData $data): ?OneToOne
    {
        if (! $data->recurring || ! $data->completed_at) {
            return null;
        }

        $recurrenceData = new OneToOneData(
            person: $data->person,
            manager: $data->manager,
            requester_id: $data->requester_id,
            person_status: OneToOneStatus::INVITED,
            manager_status: OneToOneStatus::INVITED,
            scheduled_at: $this->calculateScheduledAt($data->scheduled_at, $data->recurrence_interval),
            recurring: $data->recurring,
            recurrence_interval: $data->recurrence_interval
        );

        return $this->scheduleOneToOne->execute($recurrenceData);
    }

    /**
     * @throws Exception
     */
    protected function calculateScheduledAt(Carbon $scheduledAt, RecurrenceInterval $interval): Carbon
    {
        return match ($interval) {
            RecurrenceInterval::NEVER => throw new Exception('A Recurring One-to-one must have a recurrence interval different to never.'),
            RecurrenceInterval::WEEKLY => $scheduledAt->addWeek(),
            RecurrenceInterval::FORTNIGHTLY => $scheduledAt->addWeeks(2),
            RecurrenceInterval::MONTHLY => $scheduledAt->addMonth(),
            RecurrenceInterval::QUARTERLY => $scheduledAt->addMonths(3),
            RecurrenceInterval::BIANNUALLY => $scheduledAt->addMonths(6),
        };
    }
}
