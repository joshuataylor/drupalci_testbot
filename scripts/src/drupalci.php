<?php

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

include_once('setup.inc.php');
include_once('build.inc.php');

$console = new Application('DrupalCI - CommandLine', '0.1');

$app->boot();

// we should check if the setup is already done. if yes we should ask to use --force

$console
    ->register('setup')
    ->setDescription('Setups the Docker Enviroment with sane defaults for testing')
    ->setCode(function (InputInterface $input, OutputInterface $output) use ($app) {
        if (!$distro = getLinuxDistro())
        {
           $output->writeln('<error>ERROR</error>: Could not determine Linux distro');
           exit;
        }
        #$output->writeln('<info>INFO</info>');
        #$output->writeln('<error>ERROR</error>');
        $output->writeln("<info>INFO</info>: Running on $distro");
        $output->writeln("<info>INFO</info>: Installing Docker");
        installDocker();
    });

$console
    ->register('build')
    ->setDescription('Build Containers')
    ->setCode(function (InputInterface $input, OutputInterface $output) use ($app) {
        $container['base'] = getContainers('base');
        $container['database'] = getContainers('database');
        $container['web'] = getContainers('web');

        var_dump($container);

    });

$console
    ->register('test')
    ->setDescription('Running Tests');

return $console;
