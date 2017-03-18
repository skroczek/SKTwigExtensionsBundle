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

use SK\TwigExtensionsBundle\Twig\StringTwigExtension;

class StringTwigExtensionsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var StringTwigExtension
     */
    private $extension;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->extension = new StringTwigExtension();
    }

    public function testGetFilters()
    {
        $filters = $this->extension->getFilters();
        $this->assertTrue(is_array($filters));

        $filterNames = array(
            'ucfirst',
            'lcfirst',
        );

        $this->assertCount(count($filterNames), $filters);

        $fn = array();

        /**
         * @var \Twig_SimpleFunction $f
         */
        foreach ($filters as $f) {
            $this->assertInstanceOf('\Twig_SimpleFilter', $f);
            $fn[] = $f->getName();
        }
        $this->assertSame($fn, $filterNames);
    }

    public function testGetFunctions()
    {
        $filters = $this->extension->getFunctions();
        $this->assertTrue(is_array($filters));

        $filterNames = array(
            'ucfirst',
            'lcfirst',
        );

        $this->assertCount(count($filterNames), $filters);

        $fn = array();

        /**
         * @var \Twig_SimpleFunction $f
         */
        foreach ($filters as $f) {
            $this->assertInstanceOf('\Twig_SimpleFunction', $f);
            $fn[] = $f->getName();
        }
        $this->assertSame($fn, $filterNames);
    }

    public function testGetName()
    {
        $this->assertSame('sk_string_extension', $this->extension->getName());
    }

    public function testFilterFunctionality()
    {
        $filters = $this->extension->getFunctions();

        /**
         * @var \Twig_SimpleFunction $f
         */
        foreach ($filters as $f) {
            if ('ucfirst' === $f->getName()) {
                $ucfirst = $f->getCallable();
                $this->assertSame('Hello World', $ucfirst('hello World'));
            } elseif ('lcfirst' === $f->getName()) {
                $lcfirst = $f->getCallable();
                $this->assertSame('hello World', $lcfirst('Hello World'));
            } else {
                throw new \PHPUnit_Framework_ExpectationFailedException(sprintf('Unkown filter %s.', $f->getName()));
            }
        }
    }

    public function testFunctionFunctionality()
    {
        $functions = $this->extension->getFilters();

        /**
         * @var \Twig_SimpleFunction $f
         */
        foreach ($functions as $f) {
            if ('ucfirst' === $f->getName()) {
                $ucfirst = $f->getCallable();
                $this->assertSame('Hello World', $ucfirst('hello World'));
            } elseif ('lcfirst' === $f->getName()) {
                $lcfirst = $f->getCallable();
                $this->assertSame('hello World', $lcfirst('Hello World'));
            } else {
                throw new \PHPUnit_Framework_ExpectationFailedException(sprintf('Unkown function %s.', $f->getName()));
            }
        }
    }
}
