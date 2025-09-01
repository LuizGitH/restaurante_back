<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    use HttpResponses;
    /**
     * Handle an incoming authentication request.
     */

    public function login(Request $request)
    {
        if (Auth::attempt($request->only('email', 'password'))) {
            return $this->response('Authorized',200, [
                'token' => $request->user()->createToken('Personal Access Token')->plainTextToken
            ]);
        }
        return $this->error('Not Authorized', 403);
    }

    /*   public function store(LoginRequest $request): Response
      {
          $request->authenticate();

          $request->session()->regenerate();

          return response()->noContent();
      }
  */
      /**
       * Destroy an authenticated session.
       */
    public function destroy(Request $request): Response
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->noContent();
    }
}
