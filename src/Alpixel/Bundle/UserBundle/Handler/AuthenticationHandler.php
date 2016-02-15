<?php

namespace Alpixel\Bundle\UserBundle\Handler;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

class AuthenticationHandler implements AuthenticationSuccessHandlerInterface
{
    protected $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        $back = $request->get('back');

        if (!empty($back) && $back != "/404") {
            return new RedirectResponse($back);
        }

        return new RedirectResponse($this->router->generate('front_home'));
    }
}
