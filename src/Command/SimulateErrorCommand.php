<?php

namespace App\Command;

use App\EventListener\ErrorNotificationListener;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\Kernel\KernelInterface;

#[AsCommand(name: 'app:simulate-error', description: 'Simula una excepción y ejecuta ErrorNotificationListener')]
class SimulateErrorCommand extends Command
{
    public function __construct(
        private ErrorNotificationListener $listener,
        private KernelInterface $kernel
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $io->writeln('Simulando excepción y ejecutando ErrorNotificationListener...');

        $request = Request::create('/simulate-error', 'GET');
        $exception = new \RuntimeException('Simulated exception for testing ErrorNotificationListener');

        $event = new ExceptionEvent($this->kernel, $request, HttpKernelInterface::MAIN_REQUEST, $exception);

        $this->listener->onKernelException($event);

        $io->success('Listener ejecutado. Revisa Mailpit y var/error_notifications/failed_emails.log');

        return Command::SUCCESS;
    }
}
