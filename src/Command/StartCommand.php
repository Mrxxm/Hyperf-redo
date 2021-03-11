<?php


namespace Xxm\Command;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class StartCommand extends Command
{
    protected function configure()
    {
        $this->setName('xxm:start')->setDescription('Start Application Server.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        echo '456';

        return 1;
    }


}