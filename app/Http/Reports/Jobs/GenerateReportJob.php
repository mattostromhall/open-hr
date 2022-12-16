<?php

namespace App\Http\Reports\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Support\Actions\GenerateReportAction;
use Support\DataTransferObjects\ReportData;

class GenerateReportJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(protected GenerateReportAction $generateReport)
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(ReportData $data)
    {
        $this->generateReport->execute($data);
    }
}
