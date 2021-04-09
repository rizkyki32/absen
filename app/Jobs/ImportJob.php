<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Excel; //IMPORT CLASS EXCEL
use App\Imports\SchedulesImport; //IMPORT CLASS PRODUCTSIMPORT

class ImportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $file;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($file)
    {
        //
        $this->file = $file; // MENERIMA PARAMETER YANG DIKIRIM
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        // Excel::import(new SchedulesImport, 'public/' . $this->file);
        // unlink(storage_path('app/public/' . $this->file)); //MENGHAPUS FILE EXCEL YANG TELAH DI-UPLOAD
    }
}
