<?php

/*
 * This file is part of the ValepImmo Project.
 *
 * (c) Corentin Régnier <corentin.regnier59@gmail.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Twig;

use AppBundle\Entity\Page;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;

/**
 * Class PageExtension
 */
class PageExtension extends \Twig_Extension
{
    protected $manager;

    /**
     * PageExtension constructor.
     *
     * @param EntityManager $manager
     */
    public function __construct(EntityManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('get_pages', [$this, 'getPages'], [
                'needs_environment' => true,
                'is_safe'           => ['html'],
            ]),
        ];
    }

    /**
     * @return string
     */
    public function getPages()
    {
        /** @var Page[]|array $pages */
        $pages = $this->manager->getRepository('AppBundle:Page')->findAll();

        return $pages;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'page_extension';
    }
}
