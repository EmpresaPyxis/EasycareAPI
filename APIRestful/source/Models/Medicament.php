<?php

namespace Source\Models;

use CoffeeCode\DataLayer\DataLayer;

class Medicament extends DataLayer
{
    public function __construct()
    {
        parent::__construct("tbMedicamento", ['composicaoMed', 'descMed', 'descDosagem', 'precoMed', 'idLaboratorio', 'idCategoriaMed', 'idEstabelecimento', 'idTipoDosagem', 'idTarja'], "idMedicamento", false);
    }
}
