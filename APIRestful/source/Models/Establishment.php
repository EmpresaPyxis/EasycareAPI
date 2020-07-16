<?php

namespace Source\Models;

use CoffeeCode\DataLayer\DataLayer;

class Establishment extends DataLayer
{
  public function __construct()
  {
    parent::__construct("tbestabelecimento", ['nomeEstabelecimento', 'cnpjEstabelecimento', 'logEstabelecimento', 'numLogEstabelecimento', 'cepLogEstabelecimento', 'bairroEstabelecimento', 'ufLogEstabelecimento', 'statusEstabelecimento'], 'idEstabelecimento', false);
  }
}
