<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class EmailTraceability extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'EmailTraceability';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        //
    }
    public function fire()
    {
        $request = Request::create($this->option('uri'), 'GET');
        $this->info(app()['Illuminate\Contracts\Http\Kernel']->handle($request));
    }

    protected function getOptions()
    {
        return [
            ['uri', null, InputOption::VALUE_REQUIRED, 'The path of the route to be called', null],
        ];
    }
}
