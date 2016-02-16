<?php

namespace Alpixel\Bundle\AlpixelUserBundle\Controller;

use FOS\UserBundle\Controller\SecurityController as BaseController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends BaseController
{
    public function renderLogin(array $data)
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
        if (!empty($user) && $user != 'anon.') {
            return new RedirectResponse($this->container->get('router')->generate('front_home'));
        }

        $requestAttributes = $this->container->get('request')->attributes;
        if ($requestAttributes->get('_route') == 'admin_login') {
            $template = 'UserBundle:admin:pages/back_login.html.twig';
        } elseif ($requestAttributes->get('_route') == 'front_login') {
            $template = 'AccountBundle:front:pages/front_login.html.twig';
        } else {
            $template = 'AccountBundle:front:blocks/block_login.html.twig';
        }

        return $this->container->get('templating')->renderResponse($template, $data);
    }
}
