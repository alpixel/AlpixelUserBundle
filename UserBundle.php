<?php

namespace Alpixel\Bundle\AlpixelUserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class AlpixelUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
