<?php

namespace AppBundle\Infrastructure;

use Abraham\TwitterOAuth\TwitterOAuth;

class TweetsImporter implements ImporterInterface
{
    /**
     * @var TwitterOAuth
     */
    private $client;
}