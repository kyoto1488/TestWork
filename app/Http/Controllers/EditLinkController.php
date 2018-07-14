<?php

namespace App\Http\Controllers;

use App\Links;
use App\SessionAccount;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * Class EditLinkController
 * @package App\Http\Controllers
 */
class EditLinkController extends Controller
{
    /**
     * @param Request $request
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Request $request)
    {
        $links = Links::where('short', $request->short_key)->get();

        if ($links->count() === 0) {
            return response($request)
                ->setStatusCode(404)
                ->setContent('404');
        }

        $link = $links->first();


        return view('edit', [
            'original' => $link->original,
            'lifetime' => !is_null($link->lifetime)
                ? Carbon::parse($link->lifetime)->format('Y-m-d\TH:i')
                : null,
            'active' => $link->active,
            'link_id' => $link->short
        ]);
    }

    /**
     * @param Request $request
     * @return $this
     */
    public function edit(Request $request)
    {
        $request->validate([
            'lifetime' => 'nullable',
            'active' => 'nullable'
        ]);

        $links = Links::where([
            'short' => $request->short_key,
            'u_id' => SessionAccount::getSessionId()
        ])->get();

        if ($links->count() === 0) {
            return response($request)
                ->setStatusCode(404)
                ->setContent('404');
        }

        Links::where([
            'short' => $request->short_key,
            'u_id' => SessionAccount::getSessionId()
        ])
            ->update([
            'lifetime' => !is_null($request->lifetime)
                ? Carbon::parse($request->lifetime)->toDateTimeString()
                : null,
            'active' => (bool)$request->active
        ]);

        return redirect(route('home'))->with('success', 'Success edited link');
    }
}
