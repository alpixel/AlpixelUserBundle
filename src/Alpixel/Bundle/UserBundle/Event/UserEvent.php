<?php
namespace Alpixel\Bundle\UserBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Request;
use Alpixel\Bundle\UserBundle\Entity\User;

class UserEvent extends Event
{
    protected $user;
    protected $request;

    public function __construct(User $user, Request $request)
    {
        $this->user    = $user;
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
