<?php
/**
 * @file
 */

use Symfony\Component\Console\Application;

require 'vendor/autoload.php';

$app = new Application('Entry');

$app->add(new \CultuurNet\Auth\Command\AuthenticateCommand());
$app->add(new \CultuurNet\EntryConsole\Command\Keywords());

$app->run();
