<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Links extends Model
{
    protected $primaryKey = 'link_id';
    protected $table = 'links';

    /**
     * @return string
     */
    public static function generateUniqueId():string
    {
        $uniqueString = Random::generate(6);

        while (self::where('short', $uniqueString)->count() > 0) {
            $uniqueString = Random::generate(6);
        }

        return $uniqueString;
    }
}
