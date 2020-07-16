<?php

namespace Source\Models;
use CoffeeCode\DataLayer\DataLayer;

class UserLogin extends DataLayer
{
    public function __construct()
    {
        parent:: __construct("tblogincliente",["emailCliente", "senhaCliente"], "idLoginCliente", false);   
    }
}

?>