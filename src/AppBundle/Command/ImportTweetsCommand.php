<?php

namespace AppBundle\Command;

use AppBundle\Document\Tweet;
use AppBundle\Infrastructure\TweetsImporter;
use AppBundle\Repository\TweetWriteRepository;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ImportTweetsCommand extends ContainerAwareCommand
{
    const NAME = 'tweets:import';
    const DESCRIPTION = 'Imports Tweets into database.';
    const HELP = 'This command imports Tweets from a given user and stores them in the database.';

    /**
     * @var TweetsImporter
     */
    private $importer;

    /**
     * @var TweetWriteRepository
     */
    private $repository;

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();
        $this->importer = $container->get('twitter.tweets_importer');
    }

    protected function configure()
    {
        $this
            ->setName(self::NAME)
            ->setDescription(self::DESCRIPTION)
            ->setHelp(self::HELP);
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $tweets = $this->importer->importData();

        foreach ($tweets as $tweet) {
            $this->persistTweet($tweet);
        }

        $this->odm->flush();
    }

    /**
     * @param Tweet $tweet
     */
    private function persistTweet(Tweet $tweet)
    {
        if ($existingTweet = $this->repository->findOneBy(['twitterId' => $tweet->getTwitterId()])) {
            $tweet->setId($existingTweet->getId());
        }

        $this->odm->persist($tweet);
    }
}