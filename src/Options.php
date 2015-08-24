<?php

namespace ArjanSchouten\HTMLMin;

class Options
{
    const ALL = 'all';
    const ATTRIBUTE_QUOTES = 'remove-attributequotes';
    const EMPTY_ATTRIBUTES = 'remove-empty-attributes';
    const REMOVE_DEFAULTS = 'remove-defaults';
    const WHITESPACES = 'whitespaces';
    const COMMENTS = 'comments';

    private static $options;

    public static function options()
    {
        if (self::$options === null) {
            self::$options = [
                self::WHITESPACES        => new Option(self::WHITESPACES, 'Remove redundant spaces', true),
                self::COMMENTS           => new Option(self::COMMENTS, 'Remove comments', true),
                self::ATTRIBUTE_QUOTES   => new Option(self::ATTRIBUTE_QUOTES, 'Remove quotes around html attributes', false),
                self::REMOVE_DEFAULTS    => new Option(self::REMOVE_DEFAULTS, 'Remove defaults such as from <script type=text/javascript>', false),
                self::EMPTY_ATTRIBUTES   => new Option(self::EMPTY_ATTRIBUTES, 'Remove empty attributes. HTML boolean attributes are skipped', false)
            ];
        }

        return self::$options;
    }
}