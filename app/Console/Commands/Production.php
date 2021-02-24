<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class Production extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'production';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Hop, hop and in production!';

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
        $this->call('auth:clear-resets');
        $this->call('cache:clear');
        $this->call('config:cache');
        $this->call('route:clear');
        $this->call('view:clear');
        $this->call('migrate');
    }
}
