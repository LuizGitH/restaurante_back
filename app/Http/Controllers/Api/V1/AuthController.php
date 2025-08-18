<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use HttpResponses;

    // 5|dbk6DkNsFN78slulXo42eciwRVdP3J8ZEkJjZ1V21a973ced -> User
    // 6|m7iAdLTJDA2MknRw431SmeQv3e7P48TlxXA8mrL5fcc18226 -> Dish

    public function login(Request $request)
    {
        if (Auth::attempt($request->only('email', 'password'))) {
            return $this->response('Authorized',200, [
                'token' => $request->user()->createToken('Personal Access Token', ['user-get'])->plainTextToken
            ]);
        }
        return $this->error('Not Authorized', 403);
    }
}
