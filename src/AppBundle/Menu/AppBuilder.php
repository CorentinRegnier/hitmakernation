<?php

/*
 * This file is part of the ValepImmo Project.
 *
 * (c) Corentin Régnier <corentin.regnier59@gmail.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Menu;

use AppBundle\Entity\Page;
use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use AgileAdminBundle\Menu\Builder as BaseBuilder;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AppBuilder
 */
class AppBuilder extends BaseBuilder
{
    /**
     * @param FactoryInterface $factory
     * @param array            $options
     *
     * @return ItemInterface
     */
    public function mainMenu(FactoryInterface $factory, $options)
    {
        $menu = $factory->createItem('root');
        $this->addItem($menu, 'app.menu.homepage', 'homepage');
        $this->addItem($menu, 'Test', 'homepage');
        $this->addItem($menu, 'Test2', 'homepage');
        $this->addItem($menu, 'Test3', 'homepage');
        $this->addItem($menu, 'app.menu.admin_homepage', 'admin_homepage');

        return $menu;
    }

    /**
     * @param FactoryInterface $factory
     *
     * @return ItemInterface
     */
    public function breadcrumb(FactoryInterface $factory)
    {
        $menu = $factory->createItem('root');
        /** @var Request $request */
        $request   = $this->getRequest();
        $routeName = $request->get('_route');

        // LOGIN
        if (strpos($routeName, 'fos_user_security_login') === 0) {
            $this->addItem($menu, 'app.user.login.title', 'fos_user_security_login');
        }

        // Reset password
        if (strpos($routeName, 'fos_user_resetting') === 0) {
            $this->addItem($menu, 'app.user.resetting.title', 'fos_user_resetting_request');
        }

        // Registration
        if (strpos($routeName, 'fos_user_registration') === 0) {
            $this->addItem($menu, 'app.user.register.title', 'fos_user_registration_register');
        }

        // Profile
        if (strpos($routeName, 'fos_user_profile') === 0) {
            $this->addItem($menu, 'app.user.profile.edit.title', 'fos_user_registration_register');
        }

        if (strpos($routeName, 'page_show') === 0) {
            /** @var Page[]|array $pages */
            $pages = $this->container->get('doctrine.orm.entity_manager')->getRepository('AppBundle:Page')->findAll();
            foreach ($pages as $page) {
                if ($request->get('slug') === $page->getSlug()) {
                    $this->addItem($menu, $page->getTitle(), 'page_show', null, ['slug' => $page->getSlug()]);
                }
            }
        }

        return $menu;
    }
}
