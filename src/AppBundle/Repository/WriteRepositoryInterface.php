<?php

namespace AppBundle\Repository;

use Documents\CustomRepository\Document;

/**
 * Interface WriteRepositoryInterface
 * @package AppBundle\Infrastructure
 */
interface WriteRepositoryInterface
{
    /**
     * @param object $entity
     * @return void
     */
    public function saveOne($entity);

    /**
     * @param array $entities
     * @return void
     */
    public function saveAll(array $entities);
}