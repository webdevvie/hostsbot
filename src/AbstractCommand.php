<?php

namespace Webdevvie\Hostsbot;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Dumper;
use Symfony\Component\Yaml\Parser;

abstract class AbstractCommand extends Command
{
    protected InputInterface $input;
    protected OutputInterface $output;

    protected array $config = [];


    /**
     * @return string
     */
    public function getConfigDir()
    {
        if (strstr(__FILE__, "phar://")) {
            $path = dirname(\Phar::running(false));
            $dir = $path . "/";
            return $dir;
        }
        return dirname(__DIR__) . '/';
    }

    public function readConfig(InputInterface $input,OutputInterface $output)
    {
        $this->output = $output;
        $this->input = $input;
        $cd = $this->getConfigDir();
        $configfile = $cd . '/config.yaml';

        if (!file_exists($configfile)) {
            $configfile = '/etc/hostsbot.yaml';
        }
        if (!file_exists($configfile)) {
            throw new \Exception("Config file not found", 404);
        }
        $parser = new Parser();
        try {


            $this->config = $parser->parse(file_get_contents($configfile));
        } catch (\Exception $e) {

        }
        if (!is_array($this->config)) {
            $this->config = [];
        }
        if (!isset($this->config['etcPath'])) {
            $this->config['etcPath'] = '/etc/hosts';
        }
    }

    public function writeConfig()
    {
        $cd = $this->getConfigDir();
        $configfile = $cd . '/config.yaml';
        $dumper = new Dumper();
        $dump = $dumper->dump($this->config);
        file_put_contents($configfile, $dump);
    }

    public function writeHosts($extraFiles, $live)
    {

        ksort($extraFiles);
        $out = file_get_contents(__DIR__ . '/base.hosts');
        foreach ($extraFiles as $file => $text) {
            $out .= "\n## HOSTSBOT FILESOURCE $file START\n\n" . $text . "\n\n## HOSTSBOT FILESOURCE $file END\n";
        }
        $backup = $this->config['etcPath'] . '.' . date("YmdHis") . '.backup';
        if ($live) {

            copy($this->config['etcPath'], $backup);
            $this->output->writeln("Copied backup to <info>".$backup."</info>");
            $this->output->writeln("Writing to <info>".$this->config['etcPath']."</info>");

            file_put_contents($this->config['etcPath'], $out);
            $output = shell_exec("diff ".$this->config['etcPath'].' '.$backup);
            $this->output->writeln("<comment>".$output."</comment>");
        } else {
            $tmpfile = '/tmp/hosts-tmp.'.time();
            $this->output->writeln("Would have written to file <info>".$this->config['etcPath']."</info>");
            $this->output->writeln("Would have copied backup to file <info>".$backup."</info>");

            file_put_contents($tmpfile, $out);
            $output = shell_exec("diff ".$this->config['etcPath'].' '.$tmpfile);
            $this->output->writeln("<comment>".$output."</comment>",OutputInterface::VERBOSITY_VERBOSE);
            unlink($tmpfile);
        }

    }

}
