<?php

/*
 * This file is part of the SKTwigExtensionsBundle package.
 *
 * (c) Sebastian Kroczek <sk@xbug.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SK\TwigExtensionsBundle\Tests\Twig;

use SK\TwigExtensionsBundle\Exception\TwigFilterNotFound;
use SK\TwigExtensionsBundle\Twig\UtilTwigExtension;

class UtilTwigExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var UtilTwigExtension
     */
    private $extension;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->extension = new UtilTwigExtension();
    }

    public function testWrap()
    {
        $this->assertSame('', $this->extension->wrap(''));
        $this->assertSame('foo', $this->extension->wrap('foo'));
        $this->assertSame('<span><span>', $this->extension->wrap('', '<span>'));
        $this->assertSame('<span></span>', $this->extension->wrap('', '<span>', '</span>'));
        $this->assertSame('<span>foo<span>', $this->extension->wrap('foo', '<span>'));
        $this->assertSame('<span>foo</span>', $this->extension->wrap('foo', '<span>', '</span>'));
        $this->assertSame('foo</span>', $this->extension->wrap('foo', '', '</span>'));
        $this->assertSame(
            'aHi, I\'m class A. I\'m very talkative. Would you be my friend?c',
            $this->extension->wrap(new A(), 'a', 'c')
        );

        $exception = null;
        try {
            $this->extension->wrap(new B());
        } catch (\Exception $e) {
            $exception = $e;
        }

        $this->assertInstanceOf(\UnexpectedValueException::class, $exception);
        $this->assertSame(
            'The first argument must be a string or object implementing __toString(), "object" given.',
            $exception->getMessage()
        );
    }

    public function testEach()
    {
        $env = new \Twig_Environment(new \Twig_Loader_Array(array()));
        $env->addExtension($this->extension);

        $a = array(
            'foo',
            'bar',
        );

        $b = array(
            'bfoob',
            'bbarb',
        );

        $this->assertSame('', $this->extension->each($env));
        $this->assertSame('aaa', $this->extension->each($env, 'a', 'wrap', array('a')));
        $this->assertSame('abc', $this->extension->each($env, 'b', 'wrap', array('a', 'c')));
        $this->assertSame($a, $this->extension->each($env, $a));
        $this->assertSame($b, $this->extension->each($env, new C(), 'wrap', array('b')));
        $this->assertInstanceOf(C::class, $this->extension->each($env, new C()));
        $this->assertSame($b, $this->extension->each($env, $a, 'wrap', array('b')));

        $exception = null;
        try {
            $this->assertSame($b, $this->extension->each($env, $a, 'not_existing_function'));
        } catch (\Exception $e) {
            $exception = $e;
        }

        $this->assertInstanceOf(TwigFilterNotFound::class, $exception);
    }

    public function testGetFilters()
    {
        /** @var \Twig_SimpleFilter[] $filters */
        $filters = $this->extension->getFilters();

        $this->assertTrue(is_array($filters));

        $filterNames = array(
            'each',
            'wrap',
        );

        $fn = array();
        foreach ($filters as $f) {
            $this->assertInstanceOf('\Twig_SimpleFilter', $f);
            $fn[] = $f->getName();
        }
        $this->assertSame($fn, $filterNames);
    }

    public function testGetName()
    {
        $this->assertSame('sk_util_extension', $this->extension->getName());
    }
}

/**
 * Dummy class for testing wrap method
 * Class A.
 */
class A
{
    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return 'Hi, I\'m class A. I\'m very talkative. Would you be my friend?';
    }
}

/**
 * Dummy class for testing wrap method.
 * Class B.
 */
class B
{
}

/**
 * Dummy class implementing \Iterator interface.
 * Class C.
 */
class C implements \Iterator
{
    private $position = 0;
    private $array = array(
        'foo',
        'bar',
    );

    public function __construct()
    {
        $this->position = 0;
    }

    public function rewind()
    {
        $this->position = 0;
    }

    public function current()
    {
        return $this->array[$this->position];
    }

    public function key()
    {
        return $this->position;
    }

    public function next()
    {
        ++$this->position;
    }

    public function valid()
    {
        return isset($this->array[$this->position]);
    }
}
