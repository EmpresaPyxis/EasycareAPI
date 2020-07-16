<?php

namespace Source\Models;

use CoffeeCode\DataLayer\DataLayer;

class EstablishmentEmail extends DataLayer
{
  public function __construct()
  {
    parent::__construct("tbloginestabelecimento", ['emailEstabelecimento', 'idEstabelecimento', 'senhaEstabelecimento'], 'idLoginEstabelecimento', false);
  }
}
