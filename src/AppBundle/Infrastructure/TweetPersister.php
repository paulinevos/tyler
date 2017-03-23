<?php

namespace AppBundle\Infrastructure;

use AppBundle\Document\Tweet;
use AppBundle\Exception\DocumentNotSupportedException;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\DocumentRepository;
use Documents\CustomRepository\Document;

class TweetPersister implements DocumentPersisterInterface
{
    /**
     * @var DocumentManager
     */
    private $odm;

    /**
     * @var DocumentRepository
     */
    private $repository;

    /**
     * @param Document $document
     */
    public function persist(Document $document)
    {
        if (!$this->supportsDocumentClass(get_class($document))) {
            throw DocumentNotSupportedException::forClass(get_class($document));
        }
    }

    public function supportsDocumentClass($className)
    {
        return $className === Tweet::class;
    }
}