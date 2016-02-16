<?php

namespace Alpixel\Bundle\UserBundle\Services;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\Security\Core\SecurityContext;

class AccessManager
{
    protected $securityContext;
    protected $doctrine;

    public function __construct(Registry $doctrine, SecurityContext $context)
    {
        $this->securityContext = $context;
        $this->doctrine = $doctrine;
    }

    public function canAccess($type)
    {
    }
}
