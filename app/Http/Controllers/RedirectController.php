<?php

namespace App\Http\Controllers;

use App\Links;
use App\Stats;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Jenssegers\Agent\Agent;

/**
 * Class RedirectController
 * @package App\Http\Controllers
 */
class RedirectController extends Controller
{
    /**
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function redirect(Request $request)
    {
        $link = Links::where('short', $request->short_key)->firstOrFail();

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
        $stat->refer = $request->headers->get('referer')
            ? $request->headers->get('referer')
            : null;
        $stat->ip = $request->ip();
        $stat->browser = (new Agent)->browser();

        $stat->save();

        return redirect($link->original);
    }
}
