<?php

namespace App;

/**
 * Class Random
 * @package App
 */
class Random
{
    /**
     * @param int $len
     * @return string
     */
    public static function generate(int $len):string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $len; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}