<?php

namespace Source\Models;
use CoffeeCode\DataLayer\DataLayer;

class CuponsCliente extends DataLayer
{
    public function __construct()
    {
        parent:: __construct("tbcuponscliente",["idcupom", "idcliente"], "idcuponscliente", false);   
    }
}
