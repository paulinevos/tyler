<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class TwitterController
 * @package AppBundle\Controller
 * @Route("/twitter")
 */
class TwitterController
{
    /**
     * @Route("/", name="import_tweets")
     */
    public function indexAction()
    {
        return new JsonResponse('ayyy twitter twooter imma comin for that booter');
    }
}