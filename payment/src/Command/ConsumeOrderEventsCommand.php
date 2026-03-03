<?php

namespace App\Command;

use App\Modules\Shared\Infrastructure\Messaging\RabbitMQConsumer;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'payment:consume-orders',
    description: 'Queue payments',
)]
class ConsumeOrderEventsCommand extends Command
{
    public function __construct(private readonly RabbitMQConsumer $consumer)
    {
        parent::__construct();
    }

    // protected function configure(): void
    // {
    //     $this
    //         ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
    //         ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
    //     ;
    // }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Waiting for messages...');
        $this->consumer->consume('payment_service');

        return Command::SUCCESS;
    }
}
