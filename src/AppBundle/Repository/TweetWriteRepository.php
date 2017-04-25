<?php


namespace AppBundle\Repository;

use AppBundle\Document\Tweet;
use Doctrine\ODM\MongoDB\DocumentManager;

/**
 * Class TweetWriteRepository
 * @package AppBundle\Repository
 */
class TweetWriteRepository implements WriteRepositoryInterface
{
    /**
     * @var DocumentManager
     */
    private $odm;

    /**
     * @var TweetRepository
     */
    private $repository;

    /**
     * TweetWriteRepository constructor.
     * @param DocumentManager $odm
     * @param TweetRepository $repository
     */
    public function __construct(DocumentManager $odm, TweetRepository $repository)
    {
        $this->odm = $odm;
        $this->repository = $repository;
    }

    /**
     * @param Tweet $tweet
     */
    public function saveOne($tweet)
    {
        $this->persist($tweet);
        $this->odm->flush();
    }

    /**
     * @param array $tweets
     * @return void
     */
    public function saveAll(array $tweets)
    {
        foreach ($tweets as $tweet) {
            $this->persist($tweet);
        }

        $this->odm->flush();
    }

    /**
     * @param Tweet $tweet
     */
    private function persist(Tweet $tweet)
    {
        if ($existingTweet = $this->repository->findOneBy(['twitterId' => $tweet->getTwitterId()])) {
            $tweet->setId($existingTweet->getId());
        }

        $this->odm->persist($tweet);
    }
}