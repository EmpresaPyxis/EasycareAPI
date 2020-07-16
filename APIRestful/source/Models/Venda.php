<?php

namespace Source\Models;

use CoffeeCode\DataLayer\DataLayer;

class Venda extends DataLayer
{
    public function __construct()
    {
        parent::__construct("tbVenda", ['dataVenda', 'horaVenda', 'subTotalVenda', 'totalVenda', 'observacaoVenda', 'idCliente', 'idEnderecoCliente', 'idCupom', 'taxaEntrega', 'idProduto', 'idMedicamento', 'idEstabelecimento', 'idFormaPagamento', 'qtdProduto', 'idStatusVenda'], "idVenda", false);
    }
}
