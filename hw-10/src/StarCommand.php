<?php declare(strict_types=1);

namespace Star;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class StarCommand extends Command
{
    protected static $defaultName = 'star';

    protected function configure(): void
    {
        // TODO
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // TODO
        $output->writeln('This is not yet implemented.');

        return 0;
    }
}
