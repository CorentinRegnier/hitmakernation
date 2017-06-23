<?php

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
     * @param $html
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
