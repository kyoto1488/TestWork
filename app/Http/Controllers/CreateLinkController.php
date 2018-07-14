<?php

namespace App\Http\Controllers;

use App\Links;
use App\SessionAccount;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

/**
 * Class CreateLinkController
 * @package App\Http\Controllers
 */
class CreateLinkController extends Controller
{
    /**
     * @param Request $request
     * @return string
     */
    public function create(Request $request)
    {
        $request->validate([
            'link' => 'required',
            'lifetime' => 'nullable',
            'active' => 'required'
        ]);
        $generateUniqueId = Links::generateUniqueId();

        $link = new Links;
        $link->original = $request->link;
        $link->short = $generateUniqueId;
        $link->active = $request->active === 'on';
        $link->u_id = SessionAccount::getSessionId();

        if (!is_null($request->lifetime)) {
            $link->lifetime = Carbon::parse($request->lifetime)->toDateTimeString();
        }

        if ($link->save()) {
            return json_encode([
                'created' => true,
                'link' => URL::to($generateUniqueId)
            ]);
        }

        return json_encode(['created' => false]);
    }
}
