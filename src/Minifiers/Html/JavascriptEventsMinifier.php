<?php

namespace ArjanSchouten\HTMLMin\Minifiers\Html;

use ArjanSchouten\HTMLMin\Constants;
use ArjanSchouten\HTMLMin\Minifiers\MinifierInterface;

class JavascriptEventsMinifier implements MinifierInterface
{
    /**
     * Minify javascript prefixes on html event attributes.
     *
     * @param  \ArjanSchouten\HTMLMin\MinifyPipelineContext  $context
     * @return \ArjanSchouten\HTMLMin\MinifyPipelineContext
     */
    public function process($context)
    {
        $contents = preg_replace_callback('/'.Constants::$htmlEventNamePrefix.Constants::ATTRIBUTE_NAME_REGEX.'\s*=\s*"?\'?\s*javascript:/is',
            function ($match) {
                return str_replace('javascript:', '', $match[0]);
            }, $context->getContents());

        return $context->setContents($contents);
    }

    /**
     * Indicates if minification rules depends on command options.
     *
     * @return string|bool if an option is needed, return the option name
     */
    public function provides()
    {
        return 'remove-defaults';
    }
}
