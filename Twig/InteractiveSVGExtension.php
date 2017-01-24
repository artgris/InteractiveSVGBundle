<?php


namespace Artgris\Bundle\InteractiveSVGBundle\Twig;

use Artgris\Bundle\InteractiveSVGBundle\Utils\SVGElement;

/**
 * @author Arthur Gribet <a.gribet@gmail.com>
 */
class InteractiveSVGExtension extends \Twig_Extension
{

    protected $param;

    /**
     * InteractiveSVGExtension constructor.
     * @param $param
     */
    public function __construct($param)
    {
        $this->param = $param;
    }

    /**
     * @param \Twig_Environment $environment
     * @param $file
     * @return mixed|string
     */
    public function interactive(\Twig_Environment $environment, $file)
    {

        $svgDir = $this->param['svg_dir'];

        try {
            $svgElement = new SVGElement($svgDir . '/' . $file);
            $file = $svgElement->getSimpleSVGElement()->asXML();
        } catch (\Exception $e) {
            $file = $e->getMessage();
        }

        return $environment->render('@ArtgrisInteractiveSVG/front/svg_front.twig', [
            'file' => $file,
        ]);
    }


    /**
     * @return array
     */
    public function getFunctions()
    {
        return [
            'interactive' => new \Twig_SimpleFunction('interactive', [$this, 'interactive'], ['needs_environment' => true, 'is_safe' => ['html']]),
        ];
    }


    /**
     * @return string
     */
    public function getName()
    {
        return 'interactive';
    }


}