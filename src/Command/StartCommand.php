<?php


namespace Xxm\Command;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Xxm\Config\Config;
use Xxm\Server\ServerFactory;

class StartCommand extends Command
{
    /**
     * @var Config
     */
    protected $config;

    /**
     * StartCommand constructor.
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('xxm:start')->setDescription('Start Application Server.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $config = $this->config;
        $configs = $config->get('server');
        $serverFactory = new ServerFactory();
        $serverFactory->configure($configs);
        $serverFactory->getServer()->start();
        return 1;
    }


}