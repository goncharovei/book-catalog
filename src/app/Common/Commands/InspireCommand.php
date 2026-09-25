<?php

namespace App\Common\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;

class InspireCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:inspire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display an inspiring quote';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->comment(Inspiring::quote());
    }
}
