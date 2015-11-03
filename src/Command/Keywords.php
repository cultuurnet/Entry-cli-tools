<?php
/**
 * @file
 */

namespace CultuurNet\EntryConsole\Command;

use CultuurNet\Auth\Command\Command;
use CultuurNet\Entry\Keyword;
use CultuurNet\EntryConsole\EntryAPIFactory;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Keywords extends Command
{
    /**
     * @var EntryAPIFactory
     */
    private $entryAPIFactory;

    function __construct($name = null)
    {
        parent::__construct($name);

        $this->entryAPIFactory = new EntryAPIFactory();
    }

    protected function configure()
    {
        $this
            ->setName('event:keywords')
            ->setDescription('Change the keywords of an event')
            ->addArgument(
                'id',
                InputArgument::REQUIRED,
                'ID of the event'
            )
            ->addArgument(
                'keywords',
                InputArgument::REQUIRED | InputArgument::IS_ARRAY,
                'Keywords to add or modify'
            )
            ->addOption(
                'invisible',
                null,
                InputOption::VALUE_NONE
            )
            ->addOption(
                'entry-base-url',
                null,
                InputOption::VALUE_REQUIRED,
                'Base url of the entry web service'
            )
            ->addOption(
                'debug',
                null,
                InputOption::VALUE_NONE,
                'Output full HTTP traffic for debugging purposes'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        parent::execute($input, $output);

        $searchBaseUrl = $this->resolveBaseUrl('entry', $input);
        $user = $this->session->getUser();
        $tokenCredentials = NULL !== $user ? $user->getTokenCredentials() : NULL;
        $consumerCredentials = $this->session->getConsumerCredentials();

        $entryAPI = $this->entryAPIFactory->createService(
            $input,
            $output,
            $searchBaseUrl,
            $consumerCredentials,
            $tokenCredentials
        );

        $visible = $input->getOption('invisible') !== true;

        $keywords = [];

        foreach ($input->getArgument('keywords') as $rawKeyword) {
            $keywords[] = new Keyword(
                $rawKeyword,
                $visible
            );
        }

        $entryAPI->addKeywords(
            $input->getArgument('id'),
            $keywords
        );
    }
}
