AlpixelUserBundle
===========

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/803e613c-6e74-4774-9bec-e529adbdb27e/mini.png)](https://insight.sensiolabs.com/projects/803e613c-6e74-4774-9bec-e529adbdb27e)
[![Build Status](https://travis-ci.org/alpixel/AlpixelUserBundle.svg?branch=master)](https://travis-ci.org/alpixel/AlpixelUserBundle)
[![StyleCI](https://styleci.io/repos/50039486/shield)](https://styleci.io/repos/50039486)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/alpixel/AlpixelUserBundle/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/alpixel/AlpixelUserBundle/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/alpixel/userbundle/v/stable)](https://packagist.org/packages/alpixel/userbundle)


The AlpixelUserBundle is an integration of FOSUserBundle + Sonata admin for ALPIXEL
projects.

It comes bundled with 2 main entity :
- An abstract BaseUser which should be used to create your main user entity in the project
- An admin entity extending the BaseUser to create administrator
- Fixtures for the admin entity

## Installation


* Install the package
```
composer require 'alpixel/userbundle:~2.0'
```


* Update AppKernel.php
```

    <?php
    // app/AppKernel.php

    // ...
    class AppKernel extends Kernel
    {
        public function registerBundles()
        {
            $bundles = array(
                // ...

                new Alpixel\Bundle\UserBundle\AlpixelUserBundle(),
            );

            // ...
        }

        // ...
    }
```

* Update DB Schema

```
php app/console doctrine:schema:update
```

* Create a User entity in your AppBundle extending the BaseUser

```
<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Alpixel\Bundle\UserBundle\Entity\User as BaseUser;


/**
 * @ORM\Entity
 * @ORM\Table(name="account_user")
 */
class User extends BaseUser
{

    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

}
```


* Add the routing

```
admin:
    resource: '@AlpixelUserBundle/Resources/config/routing.yml'
```


* Customize login page

For every firewall you have to specify a template for the login page. The admin login template is always provided.
Otherwise, it should be defined using the alpixel_user.firewall_templates parameters :

```
alpixel_user:
    firewall_templates:
        admin:
            login_template: 'AlpixelUserBundle:admin:pages/back_login.html.twig'

```
