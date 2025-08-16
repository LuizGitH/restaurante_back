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

class Dishcontroller extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return DishResource::collection(Dish::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'        => 'required|string|max:255',
            'description' => 'required|string',
            'price'       => 'required|numeric|min:0',
            'category'    => 'required|string|max:100',
            'image_path'  => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return $this->error('Data Invalid', 422, $validator->errors());
        }

        $created = Dish::create($validator->validated());

        if ($created) {
            return $this->response('Dish created', 200, $created);
        }
        return $this->error('Dish not create', 400);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return new DishResource(Dish::where('id', $id)->first());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name'        => 'required|string|max:255',
            'description' => 'required|string',
            'price'       => 'required|numeric|min:0',
            'category'    => 'required|string|max:100',
            'image_path'  => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return $this->error('Data Invalid', 422, $validator->errors());
        }

        $validated = $validator->validated();

        $dish = Dish::find($id);

        if (!$dish) {
            return $this->error('Dish not found', 404);
        }

        if ($request->hasFile('image_path')) {
            $path = $request->file('image_path')->store('images', 'public');
            $validated['image_path'] = $path;
        }

        $updated = $dish ->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'category' => $validated['category'],
            'image_path' => $validated['image_path'] ?? null,
        ]);

        if ($updated) {
            return $this->response('User updated', 200, new DishResource($dish));
        }
        return $this->error('User not updated', 400);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
