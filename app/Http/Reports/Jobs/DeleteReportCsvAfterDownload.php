<?php

namespace App\Http\Reports\Jobs;

use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class DeleteReportCsvAfterDownload
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(protected string $path)
    {
        //
    }

    public function handle(): void
    {
        Storage::delete($this->path);
    }
}
