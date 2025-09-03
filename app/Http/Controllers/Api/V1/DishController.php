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

class DishController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index(Dish $query)
    {
        $dish = $query->paginate((int) request('per_page', 150));
        return DishResource::collection($dish);
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
            'image_path'  => 'required|image|max:3072',
        ]);

        if ($validator->fails()) {
            return $this->error('Data Invalid', 422, $validator->errors());
        }

        // Criar objeto Dish manualmente para poder manipular o upload
        $dish = new Dish($validator->validated());

        // Se veio imagem no request
        if ($request->hasFile('image_path')) {
            $arquivo = $request->file('image_path');
            $nomeArquivo = uniqid() . '.' . $arquivo->getClientOriginalExtension(); // nome único
            $arquivo->move(public_path('uploads'), $nomeArquivo); // mover para public/uploads

            $dish->image_path = 'uploads/' . $nomeArquivo; // salvar caminho no banco
        }

        if ($dish->save()) {
            return $this->response('Dish created', 200, $dish);
        }

        return $this->error('Dish not created', 400);
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

        // Se enviou nova imagem
        if ($request->hasFile('image_path')) {
            // Deleta a antiga se existir
            if ($dish->image_path && file_exists(public_path($dish->image_path))) {
                unlink(public_path($dish->image_path));
            }

            // Salva a nova
            $arquivo = $request->file('image_path');
            $nomeArquivo = uniqid() . '.' . $arquivo->getClientOriginalExtension();
            $arquivo->move(public_path('uploads'), $nomeArquivo);

            $validated['image_path'] = 'uploads/' . $nomeArquivo;
        }

        $updated = $dish->update($validated);

        if ($updated) {
            return $this->response('Dish updated', 200, new DishResource($dish));
        }

        return $this->error('Dish not updated', 400);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $dish = Dish::find($id);

        if (!$dish) {
            return $this->error('Dish not found', 404);
        }

        if ($dish->image_path && file_exists(public_path($dish->image_path))) {
            unlink(public_path($dish->image_path));
        }

        if ($dish->delete()) {
            return $this->response('Dish deleted', 200);
        }

        return $this->error('Dish not deleted', 400);
    }


}
