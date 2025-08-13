<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\DishResource;
use App\Http\Resources\V1\UserResource;
use App\Models\Dish;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class Usercontroller extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return UserResource::collection(User::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'string|required',
            'address' => 'string|required',
            'phone' => 'required|string|size:11',
            'email' => 'required|email|max:255',
            'CPF' => 'required|string|size:11',
            'password'  => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return $this->error('Data Invalid', 422, $validator->errors());
        }

        $created = User::create($validator->validated());

        if ($created) {
            return $this->response('User created', 200, $created);
        }
        return $this->error('User not create', 400);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return new UserResource(User::where('id', $id)->first());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
