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
use AppBundle\Entity\User;
use AppBundle\Form\Type\AdminUserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class UserController
 *
 * @Route("/utilisateur")
 */
class UserController extends Controller
{
    use UtilitiesTrait;

    /**
     * @return Response
     *
     * @Route("/index", name="admin_user_index")
     */
    public function indexAction()
    {
        $users = $this->getDoctrine()->getRepository('AppBundle:User')->findAll();

        return $this->render('admin/user/index.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse|Response
     *
     * @Route("/ajout", name="admin_user_create")
     */
    public function createAction(Request $request)
    {
        /** @var User $user */
        $user = new User();
        $form = $this->createForm(AdminUserType::class, $user, ['isCreation' => true]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                foreach ($form['roles']->getData() as $role) {
                    $user->addRole($role);
                }
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
                $this->addFlash('success', 'flashes.admin.user.create.success');

                return $this->redirectToRoute('admin_user_index');
            } catch (\Exception $e) {
                $this->addFlash('danger', 'flashes.admin.user.create.error');
            }
        }

        return $this->render('admin/user/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param int     $id
     *
     * @return RedirectResponse|Response
     *
     * @Route("/edition/{id}", name="admin_user_edit")
     */
    public function editAction(Request $request, $id)
    {
        $em   = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')->find($id);
        if (null === $user) {
            throw $this->createNotFoundException('Page introuvable.');
        }

        $form = $this->createForm(AdminUserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em->persist($user);
                $em->flush();
                $this->addFlash('success', 'flashes.admin.user.edit.success');

                return $this->redirectToRoute('admin_user_index');
            } catch (\Exception $e) {
                $this->addFlash('danger', 'flashes.admin.user.edit.error');
            }
        }

        return $this->render('admin/user/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param int $id
     *
     * @return RedirectResponse
     *
     * @Route("/suppression/{id}", name="admin_user_delete")
     */
    public function deleteAction($id)
    {
        $em   = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')->find($id);
        if (null === $user) {
            throw $this->createNotFoundException('Page introuvable.');
        }

        try {
            $em->remove($user);
            $em->flush();
            $this->addFlash('success', 'flashes.admin.user.delete.success');
        } catch (\Exception $e) {
            $this->addFlash('danger', 'flashes.admin.user.delete.error');
        }

        return $this->redirectToRoute('admin_user_index');
    }
}
