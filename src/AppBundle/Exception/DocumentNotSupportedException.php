<?php

namespace AppBundle\Exception;

use Symfony\Component\Asset\Exception\InvalidArgumentException;

class DocumentNotSupportedException extends InvalidArgumentException
{
    /**
     * @param $className
     * @return static
     */
    public static function forClass($className){
        return new static(sprintf('Class name %s not supported.', $className));
    }
}