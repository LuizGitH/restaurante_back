<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'full_name' => $this->full_name,
            'address' => $this->address,
            'phone' => $this->formatPhone($this->phone),
            'email' => $this->email,
            'firstName'  => $this->getFirstName($this->full_name),
            'CPF' =>  $this->formatCPF($this->CPF),
        ];
    }

    private function formatCPF(string $cpf): string
    {
        $cpf = preg_replace('/\D/', '', $cpf);
        return preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $cpf);
    }

    private function getFirstName(string $fullName): string
    {
        $parts = explode(' ', trim($fullName));
        return $parts[0] ?? '';
    }
    private function formatPhone(string $phone): string
    {
        $phone = preg_replace('/\D/', '', $phone);
        return preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $phone);
    }


}
