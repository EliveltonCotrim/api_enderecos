<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CepResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'cep' => $this->cep,
            'logradouro' => $this->logradouro,
            'bairro' => $this->bairro,
            'cidade' => $this->cidade,
            'uf' => $this->uf,
        ];
    }
}
