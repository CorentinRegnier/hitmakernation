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

use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Controller\Traits\UtilitiesTrait;

/**
 * Class DefaultController
 */
class DefaultController extends Controller
{
    use UtilitiesTrait;

    /**
     * @Route("/", name="admin_homepage")
     *
     * @Method({"GET"})
     *
     * @return Response
     */
    public function indexAction()
    {
        return $this->render('admin/default/index.html.twig');
    }
}
