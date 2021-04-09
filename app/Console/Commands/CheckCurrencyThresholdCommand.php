<?php

namespace App\Console\Commands;

use App\Http\Controllers\BaseCurrencyController;
use Illuminate\Console\Command;

class CheckCurrencyThresholdCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */

    protected $signature = 'CurrencyThreshold:checkThreshold';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command check currency threshold and alert user base on the user settings';

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
     * @return int
     */
    public function handle()
    {
        (new BaseCurrencyController())->checkThreshold();
    }
}
