<?php

$header = <<<EOF
This file is part of the SKTwigExtensionsBundle package.

(c) Sebastian Kroczek <sk@xbug.de>

For the full copyright and license information, please view the LICENSE
file that was distributed with this source code.
EOF;

//PhpCsFixer\Fixer\Comment\HeaderCommentFixer::setHeader($header);

$finder = PhpCsFixer\Finder::create()
    ->in([__DIR__])
    ->exclude(array('Tests/Fixtures'))
;

return PhpCsFixer\Config::create()
    ->setRules([
        '@Symfony' => true,
        'combine_consecutive_unsets' => true,
        'header_comment' => [
                'comment_type' => 'PHPDoc',
                'header' => $header
            ],
        'array_syntax' => ['syntax' => 'long'],
        'linebreak_after_opening_tag' => true,
        'no_php4_constructor' => true,
        'no_useless_else' => true,
        'ordered_class_elements' => true,
        'ordered_imports' => true,
        'php_unit_construct' => true,
        'php_unit_strict' => true,
        'phpdoc_no_empty_return' => false,
        'phpdoc_var_without_name' => false,
    ])
    ->setUsingCache(true)
    ->setFinder($finder)
;
