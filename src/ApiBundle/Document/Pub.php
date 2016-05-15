<?php

namespace ApiBundle\Document;

class Pub
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var Localization
     */
    private $localization;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $name
     *
     * @return Pub
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param Localization $localization
     *
     * @return $this
     */
    public function setLocalization(Localization $localization)
    {
        $this->localization = $localization;
        return $this;
    }

    /**
     * @return Localization $localization
     */
    public function getLocalization()
    {
        return $this->localization;
    }
}
