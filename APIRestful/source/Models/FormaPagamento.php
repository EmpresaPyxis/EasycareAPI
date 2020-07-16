<?php

namespace Source\Models;

use CoffeeCode\DataLayer\DataLayer;

class FormaPagamento extends DataLayer
{
  public function __construct()
  {
    parent::__construct("tbformapagamento", ['tipoPagamento'], 'idFormaPagamento', false);
  }
}
