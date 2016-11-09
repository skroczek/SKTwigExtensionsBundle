<?php

/*
 * This file is part of the SKTwigExtensionsBundle package.
 *
 * (c) Sebastian Kroczek <sk@xbug.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SK\TwigExtensionsBundle\Twig;

use Symfony\Component\Routing\RouterInterface;

class RoutingExtraTwigExtension extends \Twig_Extension
{
    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * TwigExtension constructor.
     *
     * @param RouterInterface $router
     */
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('link', array($this, 'link'), array('is_safe' => array('html'))),
        );
    }

    public function link($route, $text, array $routeParameter = array(), array $attr = array())
    {
        $attr['href'] = $this->router->generate($route, $routeParameter);

        $attrString = '';
        foreach ($attr as $i => $a) {
            $attrString .= ' '.$i.'="'.(is_array($a) ? implode(' ', $a) : $a).'"';
        }

        return sprintf('<a%s>%s</a>', $attrString, $text);
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'sk_routing_extra_extension';
    }
}
