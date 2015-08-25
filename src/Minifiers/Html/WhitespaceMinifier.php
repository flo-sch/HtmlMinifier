<?php

namespace ArjanSchouten\HtmlMinifier\Minifiers\Html;

use ArjanSchouten\HtmlMinifier\Constants;
use ArjanSchouten\HtmlMinifier\Minifiers\MinifierInterface;
use ArjanSchouten\HtmlMinifier\MinifyContext;
use ArjanSchouten\HtmlMinifier\Options;

class WhitespaceMinifier implements MinifierInterface
{
    /**
     * Max allowed html line length for old e.g. browsers, firewalls and routers.
     *
     * @var int
     */
    protected $maxHtmlLineLength = 32000;

    /**
     * Minification regexp's for replacing redundant whitespaces.
     *
     * @var array
     */
    protected $minifyRules = [
        '\s?=\s?' => '=',
        '\s?\/>'  => '>',
        '>\s<'    => '><',
        '\s\s'    => ' ',
        '<\s'     => '<',
        '\s>'     => '>',
        '\t'      => ' ',
        '\r'      => '',
        '\n'      => '',
    ];

    /**
     * Minify redundant whitespaces.
     *
     * @param \ArjanSchouten\HtmlMinifier\MinifyContext $context
     * @return \ArjanSchouten\HtmlMinifier\MinifyContext
     */
    public function process(MinifyContext $context)
    {
        $context->setContents($this->trailingWhitespaces($context->getContents()));
        $context->setContents($this->runMinificationRules($context->getContents()));
        $context->setContents($this->removeSpacesAroundPlaceholders($context->getContents()));

        return $context->setContents($this->maxHtmlLineLength($context->getContents(), $this->maxHtmlLineLength));
    }

    /**
     * Remove trailing whitespaces around the contents.
     *
     * @param string $contents
     * @return string
     */
    public function trailingWhitespaces($contents)
    {
        return trim($contents);
    }

    /**
     * Loop over the minification rules as long as changes in output occur.
     *
     * @param string $contents
     * @return string
     */
    public function runMinificationRules($contents)
    {
        do {
            $originalContents = $contents;
            array_walk($this->minifyRules, function ($replace, $minifyRule) use (&$contents) {
                $contents = preg_replace('/'.$minifyRule.'/', $replace, $contents);
            });
        } while ($originalContents != $contents);

        return $contents;
    }

    /**
     * Remove all spaces around placeholders.
     *
     * @param string $contents
     * @return string
     */
    public function removeSpacesAroundPlaceholders($contents)
    {
        return preg_replace('/>\s*('.Constants::PLACEHOLDER_PATTERN.')\s*</', '>$1<', $contents);
    }

    /**
     * Old browsers, firewalls and more can't handle to long lines.
     * Therefore add a linebreak after specified character length.
     *
     * @param int    $maxHtmlLineLength
     * @param string $contents
     * @return string
     */
    public function maxHtmlLineLength($contents, $maxHtmlLineLength)
    {
        if (strlen($contents) <= $maxHtmlLineLength) {
            return $contents;
        }

        $result = '';
        $splits = str_split($contents, $maxHtmlLineLength);
        foreach ($splits as $split) {
            $pos = strrpos($split, '><');
            if ($pos === false) {
                $result .= $split;
            } else {
                $result .= substr_replace($split, PHP_EOL, $pos + 1, 0);
            }
        }

        return $result;
    }

    /**
     * Indicates if minification rules depends on command options.
     *
     * @return string
     */
    public function provides()
    {
        return Options::WHITESPACES;
    }
}
