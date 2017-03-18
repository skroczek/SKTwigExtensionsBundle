<?php

/*
 * This file is part of the SKTwigExtensionsBundle package.
 *
 * (c) Sebastian Kroczek <sk@xbug.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SK\TwigExtensionBundle\Tests\DependencyInjection;

use SK\TwigExtensionsBundle\DependencyInjection\SKTwigExtensionsExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Yaml\Parser;

class SKTwigExtensionsExtensionTest extends \PHPUnit_Framework_TestCase
{
    /** @var ContainerBuilder */
    protected $configuration;

    public function testDefaultConfiguration()
    {
        $this->configuration = new ContainerBuilder();
        $loader = new SKTwigExtensionsExtension();
        $config = $this->getEmptyConfig();

        $loader->load(array($config), $this->configuration);

        $this->assertNotHasDefinition('sk.format.twig_extension');
        $this->assertNotHasDefinition('sk.routing_extra.twig_extension');
        $this->assertNotHasDefinition('sk.util.twig_extension');
        $this->assertNotHasDefinition('sk.string.twig_extension');
    }

    public function testAllEnabledConfiguration()
    {
        $this->configuration = new ContainerBuilder();
        $loader = new SKTwigExtensionsExtension();
        $config = $this->getAllConfig();

        $loader->load(array($config), $this->configuration);

        $this->assertHasDefinition('sk.format.twig_extension');
        $this->assertHasDefinition('sk.routing_extra.twig_extension');
        $this->assertHasDefinition('sk.util.twig_extension');
        $this->assertHasDefinition('sk.string.twig_extension');

        $this->assertDefinitionHasTag('sk.format.twig_extension', 'twig.extension');
        $this->assertDefinitionHasTag('sk.routing_extra.twig_extension', 'twig.extension');
        $this->assertDefinitionHasTag('sk.util.twig_extension', 'twig.extension');
        $this->assertDefinitionHasTag('sk.string.twig_extension', 'twig.extension');
    }

    protected function getEmptyConfig()
    {
        $yaml = <<<'EOF'
EOF;
        $parser = new Parser();

        return $parser->parse($yaml);
    }

    protected function getAllConfig()
    {
        $yaml = <<<'EOF'
extensions:
    format_extension: true
    util_extension: true
    routing_extra_extension: true
    string_extension: true
EOF;
        $parser = new Parser();

        return $parser->parse($yaml);
    }

    /**
     * @param string $value
     * @param string $key
     */
    private function assertAlias($value, $key)
    {
        $this->assertSame($value, (string) $this->configuration->getAlias($key), sprintf('%s alias is correct', $key));
    }

    /**
     * @param mixed  $value
     * @param string $key
     */
    private function assertParameter($value, $key)
    {
        $this->assertSame($value, $this->configuration->getParameter($key), sprintf('%s parameter is correct', $key));
    }

    /**
     * @param string $id
     */
    private function assertHasDefinition($id)
    {
        $this->assertTrue(($this->configuration->hasDefinition($id) ?: $this->configuration->hasAlias($id)));
    }

    /**
     * @param string $id
     */
    private function assertNotHasDefinition($id)
    {
        $this->assertFalse(($this->configuration->hasDefinition($id) ?: $this->configuration->hasAlias($id)));
    }

    /**
     * @param string $id
     */
    private function assertDefinitionHasTag($id, $tag)
    {
        $this->assertTrue($this->configuration->getDefinition('sk.format.twig_extension')->hasTag($tag));
    }

    /**
     * @param string $id
     */
    private function assertDefinitionNotHasTag($id, $tag)
    {
        $this->assertFalse($this->configuration->getDefinition('sk.format.twig_extension')->hasTag($tag));
    }
}
