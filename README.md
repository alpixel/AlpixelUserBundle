AlpixelUserBundle
===========

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/803e613c-6e74-4774-9bec-e529adbdb27e/mini.png)](https://insight.sensiolabs.com/projects/803e613c-6e74-4774-9bec-e529adbdb27e)
[![Build Status](https://travis-ci.org/alpixel/AlpixelUserBundle.svg?branch=master)](https://travis-ci.org/alpixel/AlpixelUserBundle)
[![StyleCI](https://styleci.io/repos/50039486/shield)](https://styleci.io/repos/50039486)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/alpixel/AlpixelUserBundle/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/alpixel/AlpixelUserBundle/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/alpixel/userbundle/v/stable)](https://packagist.org/packages/alpixel/userbundle)


The AlpixelUserBundle is an integration of FOSUserBundle + Sonata admin for ALPIXEL
projects.



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

* Start using the bundle

```
...
```
