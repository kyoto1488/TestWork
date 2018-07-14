<?php

namespace App;

/**
 * Class SessionAccount
 * @package App
 */
class SessionAccount
{
    /**
     *
     */
    public static function getSessionId():string
    {
        if (! session()->has('u_id')) {
            session()->put('u_id', self::createUniqId());
        }

        return session()->get('u_id');
    }

    /**
     * @return string
     */
    private static function createUniqId():string
    {
        $uniqueString = Random::generate(15);

        while (Links::where('u_id', $uniqueString)->count() > 0) {
            $uniqueString = Random::generate(15);
        }

        return $uniqueString;
    }

}