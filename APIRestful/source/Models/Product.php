<?php

namespace Source\Models;

use CoffeeCode\DataLayer\DataLayer;

class Product extends DataLayer
{
    public function __construct()
    {
        parent::__construct("tbProduto", ['nomeProduto', 'descProduto', 'qtdMl', 'fotoProduto', 'precoProduto', 'idCategoria', 'idFabricante', 'idEstabelecimento', 'idTipoDosagem'], "idProduto", false);
    }
}
