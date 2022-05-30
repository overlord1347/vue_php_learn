<?php

declare(strict_types=1);

namespace App\Utils;

class Strings
{
    /**
     * Remove all duplicate space and invisible chars from string
     *
     * @param string $str
     *
     * @return string
     */
    public static function removeDuplicateSpace(string $str): string
    {
        return trim(preg_replace(
            '/[\pZ\pC]+/u',
            ' ',
            $str
        ));
    }
}