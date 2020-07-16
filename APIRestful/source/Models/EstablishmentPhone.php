<?php

namespace Source\Models;

use CoffeeCode\DataLayer\DataLayer;

class EstablishmentPhone extends DataLayer
{
  public function __construct()
  {
    parent::__construct("tbfoneestabelecimento", ['numFoneEstabelecimento', 'idEstabelecimento'], 'idFoneEstabelecimento', false);
  }
}
