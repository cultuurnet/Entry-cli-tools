<?php

namespace CultuurNet\EntryConsole;

use CultuurNet\Auth\Command\CommandLineServiceFactory;
use CultuurNet\Auth\ConsumerCredentials;
use CultuurNet\Auth\TokenCredentials;
use CultuurNet\Entry\EntryAPI;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class EntryAPIFactory extends CommandLineServiceFactory
{
    /**
    * @inheritdoc
    *
    * @return EntryAPI
    */
    public function createService(
        InputInterface $in,
        OutputInterface $out,
        $baseUrl,
        ConsumerCredentials $consumer,
        TokenCredentials $token = null
    ) {
        $service = new EntryAPI($baseUrl, $consumer, $token);

        $this->registerSubscribers($in, $out, $service);

        return $service;
    }
}
