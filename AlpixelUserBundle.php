<?php

namespace Alpixel\Bundle\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class AlpixelUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
