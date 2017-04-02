<?php

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

$console = new Application('My Silex Application', 'n/a');
$console->getDefinition()->addOption(new InputOption('--env', '-e', InputOption::VALUE_REQUIRED, 'The Environment name.', 'dev'));
$console->setDispatcher($app['dispatcher']);
$console
    ->register('my-command')
    ->setDefinition(array(
        // new InputOption('some-option', null, InputOption::VALUE_NONE, 'Some help'),
    ))
    ->setDescription('My command description')
    ->setCode(function (InputInterface $input, OutputInterface $output) use ($app) {
        // do something
    });
;

$console
    ->register("generate-data-countries")
    ->setDefinition(array(
    ))
    ->setDescription('Get data countries and insert into MongoDB')
    ->setCode(function (InputInterface $input, OutputInterface $output) use ($app) {
        $output->write($app['host_country_data']);
        $output->writeln("------Retrieve data from internet--------");
        $countries = $app['model.country']->getCountriesList()
        ;
        $output->writeln("------Inserting data into database--------");
    });

return $console;
