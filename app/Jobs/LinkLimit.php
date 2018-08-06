<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Carbon\Carbon;

class LinkLimit implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Soft delete of links active over 24 hours
        \App\Link::where('created_at','<', Carbon::now()->subMinutes(3600*24)->toDateTimeString() )->delete();

        // Limit the global number of active links to 20
        $count = \App\Link::count();
        if ($count>20) {            
            \App\Link::orderBy('created_at','asc')->limit($count-20)->delete();
        }
    }
}
