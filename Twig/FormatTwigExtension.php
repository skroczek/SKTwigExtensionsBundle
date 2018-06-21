<?php

/**
 * This file is part of the SKTwigExtensionsBundle package.
 *
 * (c) Sebastian Kroczek <sk@xbug.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SK\TwigExtensionsBundle\Twig;

/**
 * Class FormatExtension.
 *
 * The 'formatBytes' method was originally written by "Paulo Ribeiro <paulo@duocriativa.com.br>" and released as part
 * of the 'BFOSTwigExtensionsBundle' under the MIT license.
 *
 * @see    https://github.com/BrazilianFriendsOfSymfony/BFOSTwigExtensionsBundle
 * @see    https://github.com/BrazilianFriendsOfSymfony/BFOSTwigExtensionsBundle/blob/e544c1f8fd0e15a79ed903e1b0b2baaa549d9460/Twig/MiscExtension.php#L50
 *
 * @author Paulo Ribeiro <paulo@duocriativa.com.br>
 * @author Sebastian Kroczek <sk@xbug.de>
 */
class FormatTwigExtension extends \Twig_Extension
{
    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('format_bytes', array($this, 'formatBytes')),
            new \Twig_SimpleFilter('repeat', 'str_repeat'),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('format_bytes', array($this, 'formatBytes')),
            new \Twig_SimpleFunction('repeat', 'str_repeat'),
        );
    }

    /**
     * Format bytes automatic into a more human readable format with units (kB/KiB, MB/MiB, ... , ZB/ZiB, YB/YiB).
     *
     * @param int|float $bytes
     * @param bool      $si    Default: false
     *
     * @return string
     */
    public function formatBytes($bytes, $si = false)
    {
        $unit = $si ? 1000 : 1024;
        if ($bytes < $unit) {
            return $bytes.' B';
        }
        $exp = intval(log($bytes) / log($unit));
        $pre = ($si ? 'kMGTPEZY' : 'KMGTPEZY');
        $pre = $pre[$exp - 1].($si ? '' : 'i');

        return sprintf('%.1f %sB', ($bytes / pow($unit, $exp)), $pre);
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'sk_format_extension';
    }
}
