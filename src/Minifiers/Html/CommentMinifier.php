<?php

namespace ArjanSchouten\HTMLMin\Minifiers\Html;

use ArjanSchouten\HTMLMin\Minifiers\MinifierInterface;
use ArjanSchouten\HTMLMin\MinifyContext;
use ArjanSchouten\HTMLMin\Options;
use Illuminate\Support\Str;

class CommentMinifier implements MinifierInterface
{
    /**
     * Replace remaining comments.
     *
     * @param \ArjanSchouten\HTMLMin\MinifyContext $context
     * @return \ArjanSchouten\HTMLMin\MinifyContext
     */
    public function process(MinifyContext $context)
    {
        return $context->setContents(preg_replace_callback(
            '/
                <!          # search for the start of a comment
                    [^>]*   # search for everything without a ">"
                >           # match the end of the comment
            /xs', function ($match) {
            if (Str::contains(strtolower($match[0]), 'doctype')) {
                return $match[0];
            }

            return '';
        }, $context->getContents()));
    }

    /**
     * Indicates if minification rules depends on command options.
     *
     * @return string
     */
    public function provides()
    {
        return Options::COMMENTS;
    }
}
