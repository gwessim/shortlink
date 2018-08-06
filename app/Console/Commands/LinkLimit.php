<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class LinkLimit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'link:limit';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove expired links and maintain 20 maximum';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        \App\Jobs\LinkLimit::dispatch();
    }
}
