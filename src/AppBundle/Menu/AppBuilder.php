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
        $this->addItem($menu, 'Accueil', 'homepage');
        $this->addItem($menu, 'Test', 'homepage');
        $this->addItem($menu, 'Test2', 'homepage');
        $this->addItem($menu, 'Test3', 'homepage');

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

        return $menu;
    }
}
