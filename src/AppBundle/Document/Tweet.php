<?php

namespace AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * Class Tweet
 * @package AppBundle\Document
 * @ODM\Document()
 */
class Tweet
{
    /**
     * @ODM\Id()
     * @var \MongoId
     */
    private $id;

    /**
     * @ODM\UniqueIndex()
     * @ODM\String()
     * @var string
     */
    private $twitterId;

    /**
     * @ODM\String()
     * @var string
     */
    private $text;

    /**
     * @ODM\Timestamp()
     * @var int
     */
    private $createdAt;

    /**
     * Tweet constructor.
     * @param \MongoId $id
     * @param string   $twitterId
     * @param string   $text
     * @param int      $createdAt
     */
    private function __construct(\MongoId $id, $twitterId, $text, $createdAt)
    {
        $this->id = $id;
        $this->twitterId = (string)$twitterId;
        $this->text = $text;
        $this->createdAt = $createdAt;
    }

    public static function fromApiEntity($entity)
    {
        $text = trim(preg_replace(
            '/\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|$!:,.;]*[A-Z0-9+&@#\/%=~_|$]/i',
            '',
            $entity->text
        ));

        $createdAt = strtotime($entity->created_at);

        return new self(new \MongoId(), $entity->id, $text, $createdAt);
    }

    /**
     * @param \MongoId $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return \MongoId
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTwitterId()
    {
        return $this->twitterId;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @return int
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}