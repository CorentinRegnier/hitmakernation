<?php

/*
 * This file is part of the ValepImmo Project.
 *
 * (c) Corentin Régnier <corentin.regnier59@gmail.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Controller\Traits;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\UserBundle\Model\UserInterface as User;

/**
 * Class UtilitiesTrait
 */
trait UtilitiesTrait
{
    /**
     * @param bool $strict
     *
     * @return null
     */
    public function getUser($strict = true)
    {
        $user = $this->doGetUser();
        if ($strict && !$user instanceof User) {
            throw new AccessDeniedException('User must be logged in.');
        }

        return $user;
    }

    /**
     * @return null
     */
    protected function doGetUser()
    {
        if (!$this->container->has('security.token_storage')) {
            throw new \LogicException('The SecurityBundle is not registered in your application.');
        }

        if (null === $token = $this->container->get('security.token_storage')->getToken()) {
            return null;
        }

        if (!is_object($user = $token->getUser())) {
            return null;
        }

        return $user;
    }

    /**
     * @param string $type
     * @param string $message
     * @param bool   $translate
     * @param array  $parameters
     * @param null   $translationDomain
     *
     * Créer un flash message avec le type de flash et le message à translate
     */
    public function addFlash($type, $message, $translate = true, $parameters = [], $translationDomain = null)
    {
        if ($translate) {
            $message = $this->get('translator')->trans($message, $parameters, $translationDomain);
        }
        $this->get('session')->getFlashBag()->add($type, $message);
    }
}
