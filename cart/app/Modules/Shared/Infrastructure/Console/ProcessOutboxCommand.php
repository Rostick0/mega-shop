<?php

namespace App\Modules\Shared\Infrastructure\Console;

use App\Modules\Shared\Application\Service\OutboxProcessorService;
use Illuminate\Console\Command;

class ProcessOutboxCommand extends Command
{
    protected $signature = 'outbox-process';
    protected $description = 'Run outbox worker';

    public function __construct(private readonly OutboxProcessorService $processor)
    {
        parent::__construct();
    }

    public function handle()
    {
        try {
            $this->info('Outbox worker started');
            while (true) {
                $this->processor->process();
                sleep(1);
            }
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
