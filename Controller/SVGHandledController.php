<?php

namespace Artgris\Bundle\InteractiveSVGBundle\Controller;

use Artgris\Bundle\InteractiveSVGBundle\Form\NodesType;
use Artgris\Bundle\InteractiveSVGBundle\Utils\SVGElement;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * SVG's handled controller
 *
 * @author Arthur Gribet <a.gribet@gmail.com>
 */
class SVGHandledController extends Controller
{

    /**
     * SVG's full list
     *
     * @Route("/", name="svg_list")
     */
    public function listAction()
    {
        $finder = new Finder();
        $finder->in($this->getSvgDir())->name('*.svg');

        foreach ($finder as $svg) {
            $svgElement = new SVGElement($svg->getRealPath());
            $svgElement->normalizedSvg();
        }

        return $this->render('@ArtgrisInteractiveSVG/back/svg/svg_list.twig', ['finder' => $finder]);
    }

    /**
     * Edit SVG
     *
     * @Route("/edit/{svgRelativePathname}", name="svg_edit")
     * @param $svgRelativePathname
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, $svgRelativePathname)
    {
        // file
        $svgElement = new SVGElement($this->getSvgRealPath($svgRelativePathname));

        // get nodes
        $nodes = $svgElement->getSVGNodes();

        $form = $this->createForm(NodesType::class, $nodes);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $nodes = $form->getData();
            $svgElement->saveNodes($nodes);
            $this->addFlash('success', "SVG saved successfully!");
            return $this->redirectToRoute("svg_edit", ['svgRelativePathname' => $svgRelativePathname]);
        }
        // SVG Html
        return $this->render('@ArtgrisInteractiveSVG/back/svg/svg_edit.twig', ['title' => $svgRelativePathname, 'svg' => $svgElement->getSimpleSVGElement()->asXML(), 'form' => $form->createView()]);
    }

    /**
     * @return mixed
     */
    private function getSvgDir()
    {
        return $this->getParameter("artgris_interactive_svg")['svg_dir'];
    }

    /**
     * @param $svgRelativePathname
     * @return string
     */
    private function getSvgRealPath($svgRelativePathname)
    {
        return $this->getSvgDir() . '/' . $svgRelativePathname;
    }

}