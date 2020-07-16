<?php

namespace Source\Models;

use CoffeeCode\DataLayer\DataLayer;

class MedicamentCategories extends DataLayer
{
    public function __construct()
    {

        parent::__construct("tbcategoriamed", ['nomeCategoria'], "idCategoriaMed", false);
    }
}
