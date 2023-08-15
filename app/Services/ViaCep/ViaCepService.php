<?php

namespace App\Services\ViaCep;

use App\Services\ViaCep\Endpoints\HasCep;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class ViaCepService
{
    use HasCep;
    public PendingRequest $api;

    public function __construct()
    {
        $this->api = Http::withHeaders(
            [
                'Accept', 'application/json'
            ]
        )->baseUrl('https://viacep.com.br/ws/');
    }
}
