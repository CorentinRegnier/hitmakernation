<?php

/*
 * This file is part of the ValepImmo Project.
 *
 * (c) Corentin Régnier <corentin.regnier59@gmail.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Page;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DefaultController
 */
class PageController extends Controller
{
    /**
     * @param Request $request
     * @param string  $slug
     *
     * @return Response
     *
     * @Route("/page/{slug}", name="page_show")
     */
    public function showAction(Request $request, $slug)
    {
        /** @var Page $page */
        $page = $this->getDoctrine()->getRepository('AppBundle:Page')->findOneBy(['slug' => $slug]);
        if (null === $page) {
            throw $this->createNotFoundException('Page introuvable.');
        }

        return $this->render('app/page/show.html.twig', [
            'page' => $page,
        ]);
    }
}
