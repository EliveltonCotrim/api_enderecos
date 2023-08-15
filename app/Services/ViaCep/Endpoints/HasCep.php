<?php

namespace App\Services\ViaCep\Endpoints;

trait HasCep {

    static function cep(){
        return new Cep();
    }

}
