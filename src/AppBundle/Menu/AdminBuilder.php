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
use Doctrine\Common\Collections\ArrayCollection;
use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use AgileAdminBundle\Menu\Builder as BaseBuilder;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AdminBuilder
 */
class AdminBuilder extends BaseBuilder
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
        /** @var Request $request */
        $request   = $this->getRequest();
        $routeName = $request->get('_route');
        $this->addItem($menu, 'admin.nav.homepage', 'admin_homepage', 'dashboard');

        // USER
        $user = $this->addItem($menu, 'admin.nav.user.title', null, 'user');
        if (strpos($routeName, 'admin_user') === 0) {
            $user->setCurrent(true);
        }
        $this->addItem($user, 'admin.nav.user.index', 'admin_user_index');
        $this->addItem($user, 'admin.nav.user.create', 'admin_user_create');

        // LEXIK
        $lexik = $this->addItem($menu, 'admin.nav.lexik_translation.index', 'lexik_translation_overview', 'globe');
        if (strpos($routeName, 'lexik_translation') === 0) {
            $lexik->setCurrent(true);
        }

        // PAGE
        $page = $this->addItem($menu, 'admin.nav.page.title', null, 'file-o');
        /** @var Page[]|ArrayCollection $pages */
        $pages = $this->container->get('doctrine.orm.entity_manager')->getRepository('AppBundle:Page')->findAll();
        if (null !== $page && null !== $pages && !empty($pages)) {
            if (strpos($routeName, 'admin_page') === 0) {
                $page->setCurrent(true);
            }
            foreach ($pages as $dynamicPage) {
                $this->addItem($page, $dynamicPage->getTitle(), 'admin_page_edit', null, [
                    'id' => $dynamicPage->getId(),
                ]);
            }
        }

        return $menu;
    }

    /**
     * @param FactoryInterface $factory
     *
     * @return ItemInterface
     */
    public function breadcrumb(FactoryInterface $factory)
    {
        /** @var Request $request */
        $request   = $this->getRequest();
        $routeName = $request->get('_route');
        $menu      = $factory->createItem('root');

        /* User */
        if (strpos($routeName, 'admin_user') === 0) {
            $this->addItem($menu, 'admin.nav.user.index', 'admin_user_index', 'list');
            if (strpos($routeName, 'admin_user_create') === 0) {
                $this->addItem($menu, 'admin.nav.user.create', 'admin_user_create', 'plus');
            }
            if (strpos($routeName, 'admin_user_edit') === 0) {
                $user = $request->get('id');
                $this->addItem(
                    $menu,
                    'admin.nav.user.edit',
                    'admin_user_edit',
                    'pencil',
                    ['id' => $user]
                );
            }
        }

        // LEXIK
        if (strpos($routeName, 'lexik_translation') === 0) {
            $this->addItem($menu, 'admin.nav.lexik_translation.index', 'lexik_translation_overview', 'globe');
            if (strpos($routeName, 'lexik_translation_grid') === 0) {
                $this->addItem($menu, 'admin.nav.lexik_translation.grid', 'lexik_translation_grid', 'language');
            }
        }

        // PAGE
        if (strpos($routeName, 'admin_page') === 0) {
            $this->addItem($menu, 'admin.nav.page.title', null, 'file-o');
            $pageId = $request->get('id');
            /** @var Page $page */
            $page = $this->container->get('doctrine.orm.entity_manager')->getRepository('AppBundle:Page')->find($pageId);
            if (strpos($routeName, 'admin_page_edit') === 0) {
                $this->addItem($menu, $page->getTitle(), 'admin_page_edit', 'pencil', ['id' => $page->getId()]);
            }
        }

        return $menu;
    }
}
