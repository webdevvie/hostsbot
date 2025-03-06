<?php

namespace Webdevvie\Hostsbot;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Webdevvie\Hostsbot\AbstractCommand;

/**
 * Class HelpCommand
 * @package Webdevvie\Pakket
 */
class HelpCommand extends AbstractCommand
{
    /**
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('help')
            ->setDescription('Displays a help message');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @throws \Exception
     * @return integer
     */
    protected function execute(InputInterface $input, OutputInterface $output):int
    {
        $output->writeln(file_get_contents(__DIR__ . '/help.txt'));
        return self::SUCCESS;
    }
}
