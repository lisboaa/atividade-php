<?php
require_once __DIR__ . '/../../conexao.php';

class CategoriaService
{
    function salvar($formData) {
        $db = Banco::getConnection();
        $salvar = $db->prepare('INSERT INTO categoria SET nome = :nome');
        $salvar->bindValue(":nome", $formData->nome, PDO::PARAM_STR);
        $salvar->execute();
        return true;
    }

}