<?php

namespace AppBundle\Infrastructure;

use Abraham\TwitterOAuth\TwitterOAuth;
use AppBundle\Document\Tweet;
use AppBundle\Infrastructure\Exception\InvalidTwitterResponseException;

/**
 * Class TweetsImporter
 * @package AppBundle\Infrastructure
 */
class TweetsImporter implements ImporterInterface
{
    /**
     * @var TwitterOAuth
     */
    private $client;

    /**
     * TweetsImporter constructor.
     * @param TwitterOAuth $client
     */
    public function __construct(TwitterOAuth $client)
    {
        $this->client = $client;
    }

    /**
     * @return array
     */
    public function importData()
    {
        $response = $this->client->get('statuses/user_timeline', [
            "screen_name" => "tylerthecreator",
            "exclude_replies" => true,
            "include_rts" => false,
            "count" => 1
        ]);

        if (!is_array($response)) {
            throw new InvalidTwitterResponseException();
        }

        return $this->extractTweets($response);
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
}
