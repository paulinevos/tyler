<?php

namespace AppBundle\Infrastructure;

use Documents\CustomRepository\Document;

interface DocumentPersisterInterface
{
    /**
     * @param Document $document
     * @return void
     */
    public function persist(Document $document);

    /**
     * @param string $className The Document class name.
     * @return boolean
     */
    public function supportsDocumentClass($className);
}