<?php

namespace ApiBundle\Document;

class Localization
{
    /**
     * @var string
     */
    public $type = 'Point';

    /**
     * @var float[]
     */
    public $coordinates;

    /**
     * @param array $coordinates
     */
    public function __construct(array $coordinates)
    {
        $this->coordinates = array_map(function ($cord) {
            return (float) $cord;
        }, $coordinates);
    }

    /**
     * @param string $type
     *
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string $type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param array $cords
     *
     * @return $this
     */
    public function setCoordinates($cords)
    {
        $this->coordinates = $cords;

        return $this;
    }

    /**
     * @return array $cords
     */
    public function getCoordinates()
    {
        return $this->coordinates;
    }
}
