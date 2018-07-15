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

        $exportData = [
            'original' => $link->original,
            'active' => $link->active,
            'link_id' => $link->short,
        ];

        if (is_null($link->lifetime)) {
            $exportData = array_merge($exportData, [
                'date' => null,
                'time' => null
            ]);
        } else {
            $lifeTime = Carbon::parse($link->lifetime);

            $exportData = array_merge($exportData, [
                'date' => $lifeTime->toDateString(),
                'time' => $lifeTime->toTimeString()
            ]);
        }

        return view('edit', $exportData);
    }

    /**
     * @param Request $request
     * @return $this
     */
    public function edit(Request $request)
    {
        $request->validate([
            'active' => 'nullable',
            'date' => 'nullable',
            'time' => 'nullable',
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

        $updateData = [
            'active' => (bool)$request->active
        ];

        if (!is_null($request->date) and !is_null($request->time)) {
            $updateData = array_merge($updateData, [
                'lifetime' => Carbon::parse($request->date . ' ' . $request->time)->toDateTimeString()
            ]);
        } else {
            $updateData = array_merge($updateData, [
                'lifetime' => null
            ]);
        }

        Links::where([
            'short' => $request->short_key,
            'u_id' => SessionAccount::getSessionId()
        ])
            ->update($updateData);

        return redirect(route('home'))->with('success', 'Success edited link');
    }
}
