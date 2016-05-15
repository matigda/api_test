<?php

namespace ApiBundle\Exception;

class PubNotFoundException extends \Exception
{
    /**
     * @param string          $message
     * @param int             $code
     * @param \Exception|null $previous
     */
    public function __construct($message = 'Pub with given id was not found', $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
