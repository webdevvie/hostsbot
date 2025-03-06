<?php

namespace Webdevvie\Hostsbot;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Dumper;
use Symfony\Component\Yaml\Parser;

/**
 * Class SyncCommand
 * @package Webdevvie\Pakket
 */
class SyncCommand extends AbstractCommand
{
    /**
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('sync')
            ->addOption("live", "l", InputOption::VALUE_NONE,"Actually write the file")
            ->setDescription('syncs /etc/hosts file with your local config');
    }
    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @throws \Exception
     * @return integer
     */
    protected function execute(InputInterface $input, OutputInterface $output):int
    {
        $this->readConfig($input,$output);
        $newHosts = [];
        if(is_dir($this->config['userDir']))
        {
           //load from dir
            $files = glob($this->config['userDir']."/*.hosts");
            ksort($files);
            foreach($files as $file)
            {
                $newHosts[$file] = file_get_contents($file);
            }
        }
        $live =$input->getOption("live");
        $this->writeHosts($newHosts,$live);


        return self::SUCCESS;
    }


}
