<?php

/*
 * This file is part of the ValepImmo Project.
 *
 * (c) Corentin Régnier <corentin.regnier59@gmail.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Controller\Admin;

use AppBundle\Controller\Traits\UtilitiesTrait;
use AppBundle\Entity\Page;
use AppBundle\Form\Type\PageType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class PageController
 *
 * @Route("/page")
 */
class PageController extends Controller
{
    use UtilitiesTrait;

    /**
     * @param Request $request
     * @param int     $id
     *
     * @return RedirectResponse|Response
     *
     * @Route("/edition/{id}", name="admin_page_edit")
     */
    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine();
        /** @var Page $page */
        $page = $em->getRepository('AppBundle:Page')->find($id);
        if (null === $page) {
            throw $this->createNotFoundException('Page introuvable.');
        }

        $form = $this->createForm(PageType::class, $page);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em->getManager()->persist($page);
                $em->getManager()->flush();

                $this->addFlash('success', 'flashes.admin.page.edit.success');

                return $this->redirectToRoute('admin_page_edit', ['id' => $page->getId()]);
            } catch (\Exception $e) {
                $this->addFlash('danger', 'flashes.admin.page.edit.error');
            }
        }

        return $this->render('admin/page/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
