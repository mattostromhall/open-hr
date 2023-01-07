<?php

namespace Support\Services;

use Closure;
use Illuminate\Support\Facades\DB;
use Support\Actions\CaptureExceptionAction;
use Throwable;

class Transaction
{
    public function __construct(protected CaptureExceptionAction $captureException)
    {
        //
    }

    /**
     * @throws Throwable
     */
    public function around(Closure $callback)
    {
        DB::beginTransaction();

        try {
            $result = $callback();

            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();

            $exceptionLog = $this->captureException->execute($e);

            return redirect()->to(route('error.captured-exception', $exceptionLog->hash));
        }

        return $result;
    }
}
