<?php

namespace ApiBundle\Provider;

class HashProvider
{
    /**
     * @param string $string
     *
     * @return string
     */
    public function getHash($string)
    {
        return md5($string);
    }
}
