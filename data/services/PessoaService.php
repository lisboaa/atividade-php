<?php
require_once __DIR__ . '/../../conexao.php';
require_once __DIR__ . '/../utils/formatarData.php';

function formatarData($data, $formato) {
    switch ($formato) {
        case 'BR':
            return implode('/', array_reverse(explode('-', $data)));
        case 'US':
            return implode('-', array_reverse(explode('/', $data)));
    }
    return false;
}

class PessoaService
{
    function salvar($formData) {

        $db = Banco::getConnection();
        $salvar = $db->prepare('INSERT INTO pessoa SET nome = :nome, 
                                                sexo = :sexo, pai = :pai, mae = :mae,
                                        endereco = :endereco, bairro = :bairro, cep = :cep, uf = :uf, telefone = :telefone,
                                         celular = :celular, email = :email,
                                         nascimento = :nascimento, cidade = :cidade');
        $salvar->bindValue(":nome",$formData->nome, PDO::PARAM_STR);
        $salvar->bindValue(":sexo",$formData->sexo, PDO::PARAM_STR);
        $salvar->bindValue(":pai", $formData->pai, PDO::PARAM_STR);
        $salvar->bindValue(":mae", $formData->mae, PDO::PARAM_STR);
        $salvar->bindValue(":endereco", $formData->endereco, PDO::PARAM_STR);
        $salvar->bindValue(":bairro", $formData->bairro, PDO::PARAM_STR);
        $salvar->bindValue(":cep", $formData->cep, PDO::PARAM_STR);
        $salvar->bindValue(":cidade", $formData->cidade, PDO::PARAM_STR);
        $salvar->bindValue(":uf", $formData->uf, PDO::PARAM_STR);
        $salvar->bindValue(":telefone", $formData->telefone,PDO::PARAM_STR );
        $salvar->bindValue(":celular", $formData->celular,PDO::PARAM_STR);
        $salvar->bindValue(":email", $formData->email, PDO::PARAM_STR);
        $salvar->bindValue(":nascimento", formatarData($formData->nascimento, 'US'), PDO::PARAM_STR);
        $salvar->execute();
        return true;
    }

    function atualizar($formData) {
        $db = Banco::getConnection();
        $atualizar = $db->prepare('UPDATE pessoa SET nome = :nome,
                                                        sexo = :sexo,
                                                        nascimento = :nascimento,
                                                        pai = :pai,
                                                        mae = :mae, 
                                                        endereco = :endereco,
                                                        bairro = :bairro,
                                                        cep = :cep,
                                                        cidade = :cidade,
                                                        uf = :uf,
                                                        telefone = :telefone,
                                                        celular = :celular,
                                                        email = :email WHERE id = :id');

        $atualizar->bindValue(":id", (int)$formData->id, PDO::PARAM_INT);
        $atualizar->bindValue(":nome", $formData->nome, PDO::PARAM_STR);
        $atualizar->bindValue(":sexo", $formData->sexo, PDO::PARAM_STR);
        $atualizar->bindValue(":nascimento", $formData->nascimento, PDO::PARAM_STR);
        $atualizar->bindValue(":pai", $formData->pai, PDO::PARAM_STR);
        $atualizar->bindValue(":mae", $formData->mae, PDO::PARAM_STR);
        $atualizar->bindValue(":endereco", $formData->endereco, PDO::PARAM_STR);
        $atualizar->bindValue(":bairro", $formData->bairro, PDO::PARAM_STR);
        $atualizar->bindValue(":cep", $formData->cep, PDO::PARAM_STR);
        $atualizar->bindValue(":cidade", $formData->cidade, PDO::PARAM_STR);
        $atualizar->bindValue(":uf", $formData->uf, PDO::PARAM_STR);
        $atualizar->bindValue(":telefone", $formData->telefone, PDO::PARAM_STR);
        $atualizar->bindValue(":celular", $formData->celular, PDO::PARAM_STR);
        $atualizar->bindValue(":email", $formData->email, PDO::PARAM_STR);
        $atualizar->execute();
        return true;
    }

    function excluir($formData) {
        $db = Banco::getConnection();
        $sql = 'DELETE FROM pessoa WHERE id = :id';
        $excluir = $db->prepare($sql);
        $excluir->bindValue(":id", $formData->id);
        $excluir->execute();
        return true;
    }

    function buscarId($formData) {
        $db = Banco::getConnection();
        $sql = "SELECT * FROM pessoa WHERE id = :id";
        $buscarPessoa = $db->prepare($sql);
        $buscarPessoa->bindValue(":id", $formData->id, PDO::PARAM_INT);
        $buscarPessoa->execute();
        $dadosPessoa = $buscarPessoa->fetch(PDO::FETCH_ASSOC);
        return (array)$dadosPessoa;
    }

    function listar() {

        $db = Banco::getConnection();
        $sql = "SELECT * FROM pessoa ORDER BY nome";
        $buscarDadosPessoa = $db->prepare($sql);
        $buscarDadosPessoa->execute();
        $dadosPessoa = $buscarDadosPessoa->fetchAll(PDO::FETCH_OBJ);
        return $dadosPessoa;
    }

}