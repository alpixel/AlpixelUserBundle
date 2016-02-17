<?php

namespace Alpixel\Bundle\UserBundle\Tests\Entity;

use Alpixel\Bundle\UserBundle\Entity\Admin;

class AdminTest extends \PHPUnit_Framework_TestCase
{
    public function testToString()
    {
        $admin = $this->getInstance();
        $this->assertEquals(' ', $admin->__toString());

        $admin->setFirstname('Jean-Jacques');
        $admin->setLastname('Maurice');
        $this->assertEquals('Jean-Jacques MAURICE', $admin->__toString());
    }

    public function getInstance()
    {
        return new Admin();
    }
}
