<?php

namespace App\Http\Controllers;

use App\Links;
use App\Stats;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

/**
 * Class RedirectController
 * @package App\Http\Controllers
 */
class RedirectController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function redirect(Request $request)
    {
        $links = Links::where('short', $request->short_key)->get();

        if ($links->count() === 0) {
            return response($request)
                ->setStatusCode(404);
        }

        $link = $links->first();

        if (!$link->active) {
            return response($request)
                ->setStatusCode(404)
                ->setContent('404');
        }

        if (!is_null($link->lifetime)) {
            $dateTimeLifeTime = Carbon::parse($link->lifetime);

            if ($dateTimeLifeTime->lt(Carbon::now()->toDateTimeString())) {
                return response($request)
                    ->setStatusCode(404)
                    ->setContent('404');
            }
        }

        $stat = new Stats;
        $stat->link_id = $link->link_id;
        $stat->redirected_at = (Carbon::now())->toDateTimeString();
        $stat->refer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null;
        $stat->ip = $_SERVER['REMOTE_ADDR'];
        $stat->browser = (new Agent)->browser();

        $stat->save();

        return redirect($link->original);
    }
}
