<?php

namespace App\Http\Controllers;

use App\Links;
use App\SessionAccount;
use App\Stats;
use Illuminate\Http\Request;

/**
 * Class StatLinkController
 * @package App\Http\Controllers
 */
class StatLinkController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function stat(Request $request)
    {
        $link = Links::where([
            'short' => $request->short_key,
            'u_id' => SessionAccount::getSessionId()
        ])->firstOrFail();

        $stats = Stats::where('link_id', $link->link_id)->get();

        return view('stat', ['stats' => $stats]);
    }
}
