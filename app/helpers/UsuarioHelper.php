<?php

class UsuariodHelper {

    public static function isWeakPassword($senha) {
        // Verifica se a senha é inteiramente numérica
        if (ctype_digit($senha)) {
            return true;
        }

        // Verifica se a senha é fraca (menos de 8 caracteres, sem letras maiúsculas, minúsculas, números e caracteres especiais)
        if (strlen($senha) < 8 ||
            !preg_match('/[A-Z]/', $senha) ||
            !preg_match('/[a-z]/', $senha) ||
            !preg_match('/[0-9]/', $senha) ||
            !preg_match('/[\W]/', $senha)) {
            return true;
        }

        return false;
    }
}


