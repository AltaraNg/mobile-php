<?php

namespace App\Http\Controllers\Auth;

use App\Helper\HttpResponseCodes;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;

class AuthenticationController extends Controller
{

    public function login(LoginRequest $request)
    {
    
    }

    

    /**
     * Log user out of the app
     */

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return $this->sendSuccess(['Successfully logged out'], HttpResponseCodes::ACTION_SUCCESSFUL);
    }
}
