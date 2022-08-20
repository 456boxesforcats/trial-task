<?php

namespace App\Classes\Helpers;

class StringHelper
{
    /**
     * @param string $input
     * @param string $separator
     * @return string
     */
    public static function toCamelCase(string $input, string $separator = '_'): string
    {
        return lcfirst(str_replace(' ', '', ucwords(str_replace($separator, ' ', $input))));
    }

    /**
     * @param string $input
     * @return string
     */
    public static function toSnakeCase(string $input): string
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $input));
    }
}
