<?php

namespace App\commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class ServeCommand extends Command
{
    protected static $defaultName = 'serve';
    protected function configure() {
        $this->setName('serve');
        $this->setDescription('Serve the application on the server');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int {
        $output->writeln('<info>Starting the development server on http://localhost:8000</info>');

        $command = ['php', '-S', 'localhost:8000', '-t', 'public'];

        $process = new Process($command);

        //$process->setTty(true);
        $process->setTimeout(null);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return Command::SUCCESS;
    }
}