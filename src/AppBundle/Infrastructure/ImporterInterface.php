<?php

namespace AppBundle\Infrastructure;

/**
 * Interface ImporterInterface
 * @package AppBundle\Infrastructure
 */
interface ImporterInterface
{
    /**
     * @return array
     */
    public function importData();
}