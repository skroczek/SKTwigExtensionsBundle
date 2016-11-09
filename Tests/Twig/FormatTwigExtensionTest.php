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

use SK\TwigExtensionsBundle\Twig\FormatTwigExtension;

class FormatTwigExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var FormatTwigExtension
     */
    private $extension;

    protected function setUp()
    {
        $this->extension = new FormatTwigExtension();
    }

    public function testGetFilters()
    {
        $filters = $this->extension->getFilters();
        $this->assertTrue(is_array($filters));

        $filterNames = array(
            'format_bytes',
            'repeat',
        );

        $this->assertCount(count($filterNames), $filters);

        $fn = array();
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
            'format_bytes',
            'repeat',
        );

        $this->assertCount(count($filterNames), $filters);

        $fn = array();
        foreach ($filters as $f) {
            $this->assertInstanceOf('\Twig_SimpleFunction', $f);
            $fn[] = $f->getName();
        }
        $this->assertSame($fn, $filterNames);
    }

    public function testGetName()
    {
        $this->assertSame('sk_format_extension', $this->extension->getName());
    }

    /**
     * @dataProvider byteProvider
     */
    public function testFormatBytes($bytes, $si, $expected)
    {
        $this->assertSame($expected, $this->extension->formatBytes($bytes, $si, false));
    }

    public function byteProvider()
    {
        return array(
            array(0, false, '0 B'),
            array(0, true, '0 B'),
            // 1000 B => 0.9765625 KiB => 1.0 KiB
            array(1000, false, '1.0 KiB'),
            // 1000 B => 1 kB => 1.0 kB
            array(1000, true, '1.0 kB'),
            // 1024 B => 1 KiB => 1.0 KiB
            array(1024, false, '1.0 KiB'),
            // 1024 B => 1 KiB => 1.0 KiB
            array(1000, false, '1.0 KiB'),
            // 1024 b => 1.024 kB => 1.0 Kb
            array(1024, true, '1.0 kB'),
            // 1996 B => 1.94921875 KiB => 1.9 KiB
            array(1996, false, '1.9 KiB'),
            // 1997 B => 1.9501953125 KiB => 2.0 KiB
            array(1997, false, '2.0 KiB'),
            // 2048 B => 2 KiB => 2.0 KiB
            array(2048, false, '2.0 KiB'),
            // 2048 B => 2.048 kB => 2.0 kB
            array(2048, true, '2.0 kB'),
            // 2050 B => 2.050 kB => 2.1 kB
            array(2050, true, '2.1 kB'),
            // 2099 B => 2.0498046875 KiB => 2.0 KiB
            array(2099, false, '2.0 KiB'),
            // 2100 B => 2.05078125 KiB => 2.1 KiB
            array(2100, false, '2.1 KiB'),
            // 1048575 B => 1023.9990234375 KiB ~> 1.0 MiB
            array(1048575, false, '1.0 MiB'),
            // 1048576 B => 1 MiB => 1.0 MiB
            array(1048576, false, '1.0 MiB'),
            // 1048576 B => 1,048576 MB => 1.0 MB
            array(1048576, true, '1.0 MB'),
            // 1073741823 B => 1023.9999990463 MiB ~> 1.0 GiB
            array(1073741823, false, '1.0 GiB'),
            // 1073741824 B => 1 GiB => 1.0 GiB
            array(1073741824, false, '1.0 GiB'),
            // 1073741824 B => 1.073741824 GB => 1.1 GB
            array(1073741824, true, '1.1 GB'),
            // 1099511627775 B => 1023.9999999991 MiB ~> 1.0 TiB
            array(1099511627775, false, '1.0 TiB'),
            // 1099511627776 B => 1 TiB => 1.0 TiB
            array(1099511627776, false, '1.0 TiB'),
            // 1099511627776 B => 1.099511627776 TB => 1.1 TB
            array(1099511627776, true, '1.1 TB'),
            // 1125899906842623 B => 1 PiB (rounded after 10 numbers behind seperator) => 1.0 PiB
            array(1125899906842623, false, '1.0 PiB'),
            // 1125899906842624 B => 1 PiB => 1.0 PiB
            array(1125899906842624, false, '1.0 PiB'),
            // 1125899906842624 B => 1.125899906842624 PB => 1.1 PiB
            array(1125899906842624, true, '1.1 PB'),
            // 1152921504606846975 B => 1 EiB (rounded after 10 numbers behind seperator)  => 1.0 EiB
            array(1152921504606846975, false, '1.0 EiB'),
            // 1152921504606846976 B => 1 EiB => 1.0 EiB
            array(1152921504606846976, false, '1.0 EiB'),
            // 1152921504606846976 B => 1.152921504606846976 EB => 1.2 EiB
            array(1152921504606846976, true, '1.2 EB'),
            // 1180591620717411303424 B => 1 ZiB => 1.0 ZiB
            array(1180591620717411303424, false, '1.0 ZiB'),
            // 1180591620717411303424 B => 1.180591620717411303424 ZB => 1.2 EiB
            array(1180591620717411303424, true, '1.2 ZB'),
            // 1208925819614629174706176 B => 1 YiB => 1.0 YiB
            array(1208925819614629174706176, false, '1.0 YiB'),
            // 1208925819614629174706176 B => 1.208925819614629174706176 YB => 1.2 YiB
            array(1208925819614629174706176, true, '1.2 YB'),

        );
    }
}
