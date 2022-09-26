<?php

namespace Domain\People\Collections;

use Domain\People\Models\Person;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;

class PersonCollection extends Collection
{
    public function mapToSelect(): SupportCollection
    {
        return $this->map(fn (Person $person) => [
            'value' => $person->id,
            'display' => $person->full_name
        ]);
    }
}
