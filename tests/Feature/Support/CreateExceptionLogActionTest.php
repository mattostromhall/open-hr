<?php

use Support\Actions\CreateExceptionLogAction;
use Support\DataTransferObjects\ExceptionLogData;

it('creates an exception log', function () {
    $action = app(CreateExceptionLogAction::class);

    try {
        throw new Exception('This is a test Exception');
    } catch (Exception $e) {
        $data = ExceptionLogData::fromException($e);
        $action->execute($data);
    }

    $this->assertDatabaseHas('exception_logs', [
        'hash' => $data->hash,
        'message' => $data->message,
        'stack_trace' => $data->stack_trace
    ]);
});
