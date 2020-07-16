<?php

namespace Source\Models;
use CoffeeCode\DataLayer\DataLayer;

class Cupom extends DataLayer
{
    public function __construct()
    {
        parent:: __construct("tbcupom",["cupom", "valorCupom"], "idCupom", false);   
    }
}
