<?php

namespace App\Http\Controllers\Auth;

use App\Helper\HttpResponseCodes;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthenticationController extends Controller
{

    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return $user->createToken($request->device_name)->plainTextToken;
    }



    /**
     * Log user out of the app
     */

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        return $this->sendSuccess(['Successfully logged out'], HttpResponseCodes::ACTION_SUCCESSFUL);
    }
}
