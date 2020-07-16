<?php

namespace Source\Models;

use CoffeeCode\DataLayer\DataLayer;

class ProductCategories extends DataLayer
{
    public function __construct()
    {
        parent::__construct("tbcategoria", ['nomeCategoria', 'idTipoProduto'], "idCategoria", false);
    }
}
