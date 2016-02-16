<?php

namespace Alpixel\Bundle\UserBundle\Controller;

use FOS\UserBundle\Controller\SecurityController as BaseController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends BaseController
{
    public function renderLogin(array $data)
    {
        $firewalls = $this->container->getMethod('security.firewall.map');

        dump($firewalls);
        foreach ($firewalls as $firewall) {
            dump($firewall);
        }
        die;
        // $token = $this->container->get('security.context')->getToken();

        // if
        // $providerKey = $securitContext->getToken()->getProviderKey();
        // dump($providerKey);die;

        // $firewallTemplates = $this->container->getParameter('alpixel_user.firewall_templates');
        // $requestAttributes = $this->container->get('request')->attributes;

        // if ($requestAttributes->get('_route') == 'admin_login') {
        //     $template = 'UserBundle:admin:pages/back_login.html.twig';
        // } elseif ($requestAttributes->get('_route') == 'front_login') {
        //     $template = 'AccountBundle:front:pages/front_login.html.twig';
        // } else {
        //     $template = 'AccountBundle:front:blocks/block_login.html.twig';
        // }

        return $this->container->get('templating')->renderResponse($template, $data);
    }
}
