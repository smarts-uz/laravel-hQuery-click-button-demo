<?php

namespace App\Console\Commands;

use App\Services\Hquery\CustomScraper;
use App\Services\WebDriver;
use Illuminate\Console\Command;

class Hquery extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:hquery {option} {url}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Runs WebDriver, available options are 1 (phone number) and 2 (titles)';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $option = (int)$this->argument('option');
        $url = (string)$this->argument('url');
        $driver = new WebDriver(new CustomScraper(), $url);

        if ($option === 1) {
            var_dump($driver->getPhoneNumber());
        } else if ($option === 2) {
            var_dump($driver->getTitles());
        }
    }
}
