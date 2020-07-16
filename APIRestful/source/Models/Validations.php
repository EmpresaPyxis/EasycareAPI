<?php

namespace Source\Models;

final class Validations
{
    public static function validationString(string $String)
    {
        return strlen($String)>=3 && !is_numeric($String);
    }

    public static function validationEmail(string $Email)
    {
        return filter_var($Email, FILTER_VALIDATE_EMAIL);
    }

    public static function validationInteger(string $Integer)
    {
        return filter_var($Integer, FILTER_VALIDATE_INT);
    }

    public static function validationCEP(string $cep)
    {
        return strlen($cep)==9;
    }

    public static function validationUF(string $uf)
    {
        return strlen($uf)==2;
    }

    public static function validationNumLog(string $nlog)
    {
        return filter_var($nlog, FILTER_VALIDATE_INT);
    }
}
?>