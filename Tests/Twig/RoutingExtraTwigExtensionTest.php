<?php

/**
 * This file is part of the SKTwigExtensionsBundle package.
 *
 * (c) Sebastian Kroczek <sk@xbug.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SK\TwigExtensionsBundle\Tests\Twig;

use SK\TwigExtensionsBundle\Twig\RoutingExtraTwigExtension;

class RoutingExtraTwigExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var RoutingExtraTwigExtension
     */
    private $extension;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $router = $this->getMockBuilder('\Symfony\Component\Routing\RouterInterface')
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
//            ->disallowMockingUnknownTypes()
            ->getMock();
        $router->method('generate')->willReturn('/foobar/barfoo');
        $this->extension = new RoutingExtraTwigExtension($router);
    }

    public function testLink()
    {
        $link = $this->extension->link('this_value_is_more_or_less_ignored', 'barfoo');
        $this->assertSame('<a href="/foobar/barfoo">barfoo</a>', $link);

        $link = $this->extension->link('this_value_is_more_or_less_ignored', 'barfoo', array(), array('data-foo' => 'foo-data'));
        $this->assertSame('<a data-foo="foo-data" href="/foobar/barfoo">barfoo</a>', $link);

        $link = $this->extension->link(
            'this_value_is_more_or_less_ignored',
            'barfoo',
            array(),
            array('data-foo' => 'foo-data', 'href' => '/should/be/ignored')
        );
        $this->assertSame('<a data-foo="foo-data" href="/foobar/barfoo">barfoo</a>', $link);
    }

    public function testGetFunctions()
    {
        $filters = $this->extension->getFunctions();

        $this->assertTrue(is_array($filters));

        $filterNames = array(
            'link',
        );

        $fn = array();
        foreach ($filters as $f) {
            $this->assertInstanceOf('\Twig_SimpleFunction', $f);
            $fn[] = $f->getName();
        }

        $this->assertSame($fn, $filterNames);
    }

    public function testGetName()
    {
        $this->assertSame('sk_routing_extra_extension', $this->extension->getName());
    }
}
