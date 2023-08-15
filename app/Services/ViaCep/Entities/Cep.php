<?php

namespace App\Services\ViaCep\Entities;

class Cep
{

    public string $cep;
    public string $logradouro;
    public string $bairro;
    public string $cidade;
    public string $uf;

    public function __construct(array $data)
    {
        $this->cep = data_get($data, 'cep');
        $this->logradouro = data_get($data, 'logradouro');
        $this->bairro = data_get($data, 'bairro');
        $this->cidade = data_get($data, 'localidade');
        $this->uf = data_get($data, 'uf');
    }
}
