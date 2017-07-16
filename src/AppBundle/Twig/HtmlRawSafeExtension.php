<?php

/*
 * This file is part of the Hit Maker Nation Project.
 *
 * (c) Corentin Régnier <corentin.regnier59@gmail.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Twig;

/**
 * Class HtmlRawSafeExtension
 */
class HtmlRawSafeExtension extends \Twig_Extension
{
    /**
     * @return array
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('html_raw', [$this, 'html'], ['is_safe' => ['htmlRaw']]),
        ];
    }

    /**
     * @param mixed $html
     *
     * @return mixed
     */
    public function htmlRaw($html)
    {
        return $html;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'twig_extension_html_raw';
    }
}
