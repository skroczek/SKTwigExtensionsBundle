SKTwigExtensionsBundle
======================

[![Build Status](https://api.travis-ci.org/skroczek/SKTwigExtensionsBundle.svg?branch=master)](https://travis-ci.org/skroczek/SKTwigExtensionsBundle)

Installation
------------

### Step 1: Download the Bundle


Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```console
$ composer require sk/twig-extensions-bundle
```

This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

### Step 2: Enable the Bundle

Then, enable the bundle by adding it to the list of registered bundles
in the `app/AppKernel.php` file of your project:

```php
<?php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...

            new SK\TwigExtensionsBundle\SKTwigExtensionsBundle(),
        );

        // ...
    }

    // ...
}
```

### Step 3: Activate the extensions you want

By default all extensions are disabled. But you can easily activate the extensions you want:

```yml
sk_twig_extensions:
    extensions:
        format_extension: true
        routing_extra_extension: true
        util_extension: true
```

What you will get
-----------------

You will get a short set of useful and handy twig functions and filter. For more information and examples follow the links. 

### Included Extensions

* [Format Extension](Resources/doc/FormatExtension.md)
  * *Filter*
    * [format_bytes](Resources/doc/FormatExtension.md#filter-format_bytes)
    * [repeat](Resources/doc/FormatExtension.md#filter-repeat)
  * *Functions*
    * [format_bytes](Resources/doc/FormatExtension.md#function-format_bytes)
    * [repeat](Resources/doc/FormatExtension.md#function-format_bytes)
* [Routing Extra Extension](Resources/doc/RoutingExtraExtension.md)
  * *Functions*
    * [link](Resources/doc/RoutingExtraExtension.md#function-link)
* [Util Extension](Resources/doc/UtilExtension.md)
  * *Filter*
    * [each](Resources/doc/UtilExtension.md#filter-each)
    * [warp](Resources/doc/UtilExtension.md#filter-wrap)
    
License
==========

This bundle is under the MIT license. See the complete license in the bundles LICENSE file.

