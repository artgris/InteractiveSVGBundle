<?php

namespace Artgris\Bundle\InteractiveSVGBundle\Entity;


use Doctrine\Common\Collections\ArrayCollection;

/**
 * @author Arthur Gribet <a.gribet@gmail.com>
 */
class Nodes
{

    const HOVER_DEFAULT_COLOR = "CABEBE";

    private $viewBoxMinx;
    private $viewBoxMiny;
    private $viewBoxWidth;
    private $viewBoxHeight;
    private $dataHoverColor = self::HOVER_DEFAULT_COLOR;
    private $nodes;

    /**
     * Nodes constructor.
     */
    public function __construct()
    {
        $this->nodes = new ArrayCollection();
    }


    /**
     * @return mixed
     */
    public function getNodes()
    {
        return $this->nodes;
    }

    /**
     * @param mixed $nodes
     */
    public function setNodes($nodes)
    {
        $this->nodes = $nodes;
    }


    /**
     * @param $node
     */
    public function addNode($node)
    {
        $this->nodes->add($node);
    }

    /**
     * @return mixed
     */
    public function getViewBoxMinx()
    {
        return $this->viewBoxMinx;
    }

    /**
     * @param mixed $viewBoxMinx
     */
    public function setViewBoxMinx($viewBoxMinx)
    {
        $this->viewBoxMinx = $viewBoxMinx;
    }

    /**
     * @return mixed
     */
    public function getViewBoxMiny()
    {
        return $this->viewBoxMiny;
    }

    /**
     * @param mixed $viewBoxMiny
     */
    public function setViewBoxMiny($viewBoxMiny)
    {
        $this->viewBoxMiny = $viewBoxMiny;
    }

    /**
     * @return mixed
     */
    public function getViewBoxWidth()
    {
        return $this->viewBoxWidth;
    }

    /**
     * @param mixed $viewBoxWidth
     */
    public function setViewBoxWidth($viewBoxWidth)
    {
        $this->viewBoxWidth = $viewBoxWidth;
    }

    /**
     * @return mixed
     */
    public function getViewBoxHeight()
    {
        return $this->viewBoxHeight;
    }

    /**
     * @param mixed $viewBoxHeight
     */
    public function setViewBoxHeight($viewBoxHeight)
    {
        $this->viewBoxHeight = $viewBoxHeight;
    }


    /**
     * @return string
     */
    public function getViewBox()
    {
        return "{$this->viewBoxMinx} {$this->viewBoxMiny} {$this->viewBoxWidth} {$this->viewBoxHeight}";
    }


    /**
     * @param $viewBox
     * @return $this
     */
    public function setViewBox($viewBox)
    {
        $explodeViewBox = explode(" ", $viewBox);
        if (count($explodeViewBox) === 4) {
            $this->setViewBoxMinx($explodeViewBox[0]);
            $this->setViewBoxMiny($explodeViewBox[1]);
            $this->setViewBoxWidth($explodeViewBox[2]);
            $this->setViewBoxHeight($explodeViewBox[3]);
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getDataHoverColor()
    {
        return $this->dataHoverColor;
    }

    /**
     * @param string $dataHoverColor
     */
    public function setDataHoverColor($dataHoverColor)
    {
        $this->dataHoverColor = $dataHoverColor;
    }


}