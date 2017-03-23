<?php

namespace AppBundle\Command;

use Abraham\TwitterOAuth\TwitterOAuth;
use AppBundle\Document\Tweet;
use AppBundle\Infrastructure\TweetsImporter;
use AppBundle\Repository\TweetRepository;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ImportTweetsCommand extends ContainerAwareCommand
{
    /**
     * @var TweetsImporter
     */
    private $importer;

    /**
     * @var DocumentManager
     */
    private $odm;

    /**
     * @var TweetRepository
     */
    private $repository;

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();
        $this->importer = $container->get('twitter.tweets_importer');
        $this->persister = $container->get('doctrine.odm.mongodb.document_manager');
        $this->repository = $this->odm->getRepository(Tweet::class);
    }

    protected function configure()
    {
        $this
            ->setName('tweets:import')
            ->setDescription('Imports Tweets into database.')
            ->setHelp('This command imports Tweets from a given user and stores them in the database.');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $response = $this->client->get('statuses/user_timeline', [
            "screen_name" => "tylerthecreator",
            "exclude_replies" => true,
            "include_rts" => false,
            "count" => 1
        ]);

        $tweets = $this->extractTweets($response);

        foreach ($tweets as $tweet) {
            $this->persistTweet($tweet);
        }

        $this->odm->flush();
    }

    /**
     * @param array $response
     * @return array
     */
    private function extractTweets(array $response)
    {
        $tweets = [];

        foreach ($response as $tweet) {
            $tweets[] = Tweet::fromApiEntity($tweet);
        }

        return $tweets;
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