<?php

namespace Alpixel\Bundle\UserBundle\Controller;

use FOS\UserBundle\Controller\SecurityController as BaseController;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends BaseController
{
    public function renderLogin(array $data)
    {
        $request = $this->container->get('request');

        $template = 'AlpixelUserBundle:admin:page/login.html.twig';

        $firewallTemplates = $this->container->getParameter('alpixel_user.firewall_templates');
        foreach ($firewallTemplates as $templateParam) {
            if (strstr($templateParam['login_path'], $request->getPathinfo()) !== false) {
                $template = $templateParam['login_template'];
                break;
            }
        }

        return $this->container->get('templating')->renderResponse($template, array_merge($data, [
            'background_image' => $this->container->getParameter('alpixel_user.default_login_background_image'),
            'color'            => $this->container->getParameter('alpixel_user.default_login_background_color'),
        ]));
    }
}
