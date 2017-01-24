<?php

namespace Artgris\Bundle\InteractiveSVGBundle\Entity;

/**
 * @author Arthur Gribet <a.gribet@gmail.com>
 */
class Node
{

    private $id;
    private $title;
    private $colorCode;
    private $strokeCode;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getColorCode()
    {
        return $this->colorCode;
    }

    /**
     * @param mixed $colorCode
     */
    public function setColorCode($colorCode)
    {
        $this->colorCode = $colorCode;
    }

    /**
     * @return mixed
     */
    public function getStrokeCode()
    {
        return $this->strokeCode;
    }

    /**
     * @param mixed $strokeCode
     */
    public function setStrokeCode($strokeCode)
    {
        $this->strokeCode = $strokeCode;
    }

    /**
     * @return mixed
     */
    public function getHashColorCode()
    {
        return $this->hashCode($this->colorCode);
    }

    /**
     * @return mixed
     */
    public function getHashStrokeCode()
    {
        return $this->hashCode($this->strokeCode);
    }

    /**
     * @return mixed
     */
    public function getIdList()
    {
        return str_replace('zone', 'list', $this->getId());
    }

    /**
     * @param $code
     * @return null|string
     */
    private function hashCode($code)
    {
        return $code ? "#{$code}" : null;
    }

}