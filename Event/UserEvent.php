<?php

namespace Alpixel\Bundle\AlpixelUserBundle\Event;

use Alpixel\Bundle\AlpixelUserBundle\Entity\User;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Request;

class UserEvent extends Event
{
    protected $user;
    protected $request;

    public function __construct(User $user, Request $request)
    {
        $this->user = $user;
        $this->request = $request;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getRequest()
    {
        return $this->request;
    }
}
