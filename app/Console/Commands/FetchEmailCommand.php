<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\FetchEmailJob;

class FetchEmailCommand extends Command
{
    protected $signature = 'email:fetch';
    protected $description = 'Fetch emails every 10 seconds';

    public function handle()
    {
        FetchEmailJob::dispatch();
    }
}