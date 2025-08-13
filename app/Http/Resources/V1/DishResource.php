<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DishResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name'=> $this->name,
            'description'=> $this->description,
            'price'=> 'R$' . number_format($this->price,2,',','.'),
            'category'=> $this->category,
            'image_path'=> $this->image_path,
        ];
    }
}
