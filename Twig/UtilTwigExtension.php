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

use SK\TwigExtensionsBundle\Exception\TwigFilterNotFound;

class UtilTwigExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('each', array($this, 'each'), array('needs_environment' => true)),
            new \Twig_SimpleFilter('wrap', array($this, 'wrap'), array('is_safe' => array('html'))),
        );
    }

    /**
     * Wraps string within pre and post strings. If no post string is given, the pre string is used as post string.
     *
     * @param string $string
     * @param string $pre
     * @param string $post
     *
     * @return string
     */
    public function wrap($string, $pre = '', $post = '')
    {
        if (null !== $string && !is_string($string) && !is_numeric($string) && !is_callable(array($string, '__toString'))) {
            throw new \UnexpectedValueException(
                sprintf(
                    'The first argument must be a string or object implementing __toString(), "%s" given.',
                    gettype($string)
                )
            );
        }

        return $pre.((string) $string).('' !== $post ? $post : $pre);
    }

    /**
     * Applies filter to value by name. If the value is an array or implements the \Traversable interface the filter is
     * applied to every element. When the filter needs additional arguments, it is possible to add them as the
     * filterArgs array.
     *
     * @param \Twig_Environment        $env
     * @param mixed|array|\Traversable $value
     * @param string                   $filter
     * @param array                    $filterArgs
     *
     * @return array|string
     *
     * @throws TwigFilterNotFound
     */
    public function each(\Twig_Environment $env, $value = '', $filter = '', array $filterArgs = array())
    {
        if (empty($value) || empty($filter)) {
            return $value;
        }

        if (!$twigFilter = $env->getFilter($filter)) {
            throw new TwigFilterNotFound(sprintf('Unable to find filter "%s".', $filter));
        }

        if (is_array($value) || $value instanceof \Traversable) {
            $a = array();
            foreach ($value as $k => $v) {
                $args = $filterArgs;
                array_unshift($args, $v);
                $a[$k] = call_user_func_array($twigFilter->getCallable(), $args);
            }
        } else {
            $args = $filterArgs;
            array_unshift($args, $value);
            $a = call_user_func_array($twigFilter->getCallable(), $args);
        }

        return $a;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'sk_util_extension';
    }
}
