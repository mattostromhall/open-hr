<?php

namespace App\Http\Reports\Jobs;

use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class DeleteReportCsvAfterDownload
{
    use Dispatchable;
    use SerializesModels;

    public function handle(string $csv): void
    {
        Storage::delete($csv);
    }
}
