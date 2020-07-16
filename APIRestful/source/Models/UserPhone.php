<?php

namespace Source\Models;
use CoffeeCode\DataLayer\DataLayer;

class UserPhone extends DataLayer
{
    public function __construct()
    {
        parent:: __construct("tbfonecliente",["numFoneCliente"], "idFoneCliente", false);   
    }
}

?>