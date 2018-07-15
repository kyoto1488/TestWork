<?php

namespace App\Http\Controllers;

use App\Links;
use App\SessionAccount;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

/**
 * Class CreatedLinkController
 * @package App\Http\Controllers
 */
class CreatedLinkController extends Controller
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function get(Request $request)
    {
        return Links::where('u_id', SessionAccount::getSessionId())
            ->get()
            ->map(function($item) {
                $item->short_link = URL::to($item->short);

                if (!is_null($item->lifetime)) {
                    $dateTimeLifeTime = Carbon::parse($item->lifetime);
                    $item->is_dead = $dateTimeLifeTime->lt(Carbon::now()->toDateTimeString());
                }

                return $item;
            })
            ->toJson();
    }
}
