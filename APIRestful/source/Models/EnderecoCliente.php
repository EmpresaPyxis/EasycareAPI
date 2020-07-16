<?php

namespace Source\Models;
use CoffeeCode\DataLayer\DataLayer;

class EnderecoCliente extends DataLayer
{
    public function __construct()
    {
        parent:: __construct("tbenderecocliente",["logCliente", "numLogCliente", "complementoLogCliente", "bairroLogCliente", "cidadeLogCliente", "ufLogCliente", "cepLogCliente","idCliente","idLocal"], "idEnderecoCliente", false);   
    }
}
