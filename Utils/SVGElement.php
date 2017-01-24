<?php

namespace Artgris\Bundle\InteractiveSVGBundle\Utils;

use Artgris\Bundle\InteractiveSVGBundle\Entity\Node;
use Artgris\Bundle\InteractiveSVGBundle\Entity\Nodes;
use SimpleXMLElement;

/**
 *
 * @author Arthur Gribet <a.gribet@gmail.com>
 */
class SVGElement
{

    private $path;
    private $simpleSVGElement;

    /**
     * SVGElement constructor.
     * @param $path
     */
    public function __construct($path)
    {
        $this->path = $path;
        $this->simpleSVGElement = new SimpleXMLElement($path, 0, true);
        $this->simpleSVGElement->registerXPathNamespace('svg', 'http://www.w3.org/2000/svg');
    }


    /**
     * @return Nodes
     */
    public function getSVGNodes()
    {
        $colorHandled = new ColorHandled();

        // Get all graphic elements (path, ellipse ...)
        $graphicElements = $this->getAllGraphicElements();
        $nodes = new Nodes();
        $nodes->setViewBox($this->simpleSVGElement['viewBox']);
        $nodes->setDataHoverColor($this->simpleSVGElement['data-hover']);

        foreach ($graphicElements as $graphicElement) {
            // foreach path, eclipse ...
            foreach ($graphicElement as &$domElement) {

                /** @var SimpleXMLElement $domElement */
                $idNode = $domElement['id'];
                $titreNode = $domElement['title'];
                $fillNode = $domElement['fill'];
                $strokeNode = $domElement['stroke'];
                $styleNode = $domElement['style'];

                // Normalized ID
                if (!$idNode || substr($idNode, 0, 5) !== "zone-") {
                    $id = 'zone-' . bin2hex(openssl_random_pseudo_bytes(6));

                    // update idNode
                    $idNode = $domElement['id'] = $id;
                }

                // Normalized style
                if ($styleNode) {
                    // get style.fill and color code
                    $matchesFill = $this->pregMatchFill($styleNode);
                    if ($matchesFill) {
                        $fillNode = $matchesFill[1];
                    }
                    $matchesStroke = $this->pregMatchStroke($styleNode);
                    if ($matchesStroke) {
                        $strokeNode = $matchesStroke[1];
                    }
                }

                // convert color name to hex
                $fillNode = $colorHandled->colorNameToHex($fillNode);
                $strokeNode = $colorHandled->colorNameToHex($strokeNode);

                $domElement['fill'] = $fillNode;

                unset($domElement['style']);

                // add Node
                $node = new Node();
                $node->setId($idNode);
                $node->setTitle($titreNode);
                $node->setColorCode($fillNode);
                $node->setStrokeCode($strokeNode);
                $nodes->addNode($node);
            }
        }

        $this->simpleSVGElement->saveXML($this->path);

        return $nodes;
    }


    /**
     * Save Nodes
     * @param Nodes $nodes
     */
    public function saveNodes(Nodes $nodes)
    {
        $viewBox = $nodes->getViewBox();
        $dataHoverColor = $nodes->getDataHoverColor();

        foreach ($nodes->getNodes() as $node) {

            /** @var Node $node */
            $nodeId = $node->getId();
            $nodeTitle = $node->getTitle();
            $nodeHashColorCode = $node->getHashColorCode();
            $nodeHashStrokeCode = $node->getHashStrokeCode();

            $xpath = "//svg:*[@id='{$nodeId}'][1]";

            $domElement = $this->simpleSVGElement->xpath($xpath)[0];

            // set title
            $domElement['title'] = $nodeTitle;
            $domElement['fill'] = $nodeHashColorCode;
            $domElement['stroke'] = $nodeHashStrokeCode;

        }

        if (null === $this->simpleSVGElement['viewBox']) {
            $this->simpleSVGElement->addAttribute('viewBox', $viewBox);
        } else {
            $this->simpleSVGElement['viewBox'] = $viewBox;
        }

        $this->simpleSVGElement['data-hover'] = $dataHoverColor;
        $this->simpleSVGElement->saveXML($this->path);
    }


    /**
     * normalizedSvg svg
     */
    public function normalizedSvg()
    {
        if ($this->simpleSVGElement['data-hover'] === null) {
            $this->simpleSVGElement->addAttribute('data-hover', Nodes::HOVER_DEFAULT_COLOR);
        }
        $this->simpleSVGElement['width'] = "100%";
        unset($this->simpleSVGElement['height']);
        $this->simpleSVGElement->saveXML($this->path);
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param mixed $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @return SimpleXMLElement
     */
    public function getSimpleSVGElement()
    {
        return $this->simpleSVGElement;
    }

    /**
     * @param SimpleXMLElement $simpleSVGElement
     */
    public function setSimpleSVGElement($simpleSVGElement)
    {
        $this->simpleSVGElement = $simpleSVGElement;
    }


    /**
     * Get all graphic elements
     * @return array
     */
    private function getAllGraphicElements()
    {
        $graphicElements = [
            'circle',
            'ellipse',
            'image',
            'line',
            'mesh',
            'path',
            'polygon',
            'polyline',
            'rect',
            'text',
            'use'
        ];
        $elements = [];
        foreach ($graphicElements as $graphicElement) {
            $elements[$graphicElement] = $this->simpleSVGElement->xpath('//svg:' . $graphicElement);
        }
        return $elements;
    }

    /**
     * @param $styleNode
     * @return mixed
     */
    private function pregMatchFill($styleNode)
    {
        preg_match("/fill:(#?.*?)(?:;|$)/", $styleNode, $matches);
        return $matches;
    }

    /**
     * @param $styleNode
     * @return mixed
     */
    private function pregMatchStroke($styleNode)
    {
        preg_match("/stroke:(#?.*?)(?:;|$)/", $styleNode, $matches);
        return $matches;
    }

}