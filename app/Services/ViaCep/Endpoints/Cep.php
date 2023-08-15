<?php

namespace App\Services\ViaCep\Endpoints;

use App\Services\ViaCep\Entities\Cep as EntitiesCep;
use App\Services\ViaCep\ViaCepService;

class Cep
{
    private ViaCepService $service;

    public function __construct()
    {
        $this->service = new ViaCepService();
    }

    public function get($cep)
    {
        return $this->transform($this->service->api->get($cep . '/json')->json());
    }

    public function transform(mixed $json)
    {
        $response['data'] = $json;

        return collect($response)->map(function ($cep) {
            return new EntitiesCep($cep);
        });
    }
}
