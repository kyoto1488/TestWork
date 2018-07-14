<?php

namespace App\Http\Controllers;

use App\Links;
use App\SessionAccount;
use Illuminate\Http\Request;

/**
 * Class RemoveLinkController
 * @package App\Http\Controllers
 */
class RemoveLinkController extends Controller
{
    /**
     * @param Request $request
     */
    public function remove(Request $request)
    {
        $request->validate([
            'short_key' => 'required'
        ]);

        Links::where([
            'u_id' => SessionAccount::getSessionId(),
            'short' => $request->short_key
        ])->forceDelete();
    }
}
