<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionDebugController extends Controller
{
    public function debug(Request $request)
    {
        return response()->json([
            'session_data' => [
                'all' => $request->session()->all(),
                'user_id' => $request->session()->get('user_id'),
                'is_admin' => $request->session()->get('is_admin'),
            ],
            'auth' => [
                'check' => Auth::check(),
                'user' => Auth::user(),
                'id' => Auth::id(),
            ],
            'cookies' => $request->cookies->all(),
            'session_status' => session_status(),
            'session_config' => config('session'),
        ]);
    }
}
