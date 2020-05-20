<?php

require 'conexao.php';

//function formatarData($data, $format) {
//    switch ($format) {
//        case 'BR':
//            return implode('/', array_reverse(explode('-', $data)));
//        case 'US':
//            return implode('-', array_reverse(explode('/', $data)));
//    }
//    return '';
//}

$acao = $_REQUEST['acao'];
//var_dump($acao);die(0);
switch ($acao) {
    case 'gravar':
        try {
            $db = Banco::getConnection();
            $salvar = $db->prepare('INSERT INTO pessoa SET nome = :nome, 
                                                    sexo = :sexo, pai = :pai, mae = :mae,
                                            endereco = :endereco, bairro = :bairro, cep = :cep, uf = :uf, telefone = :telefone,
                                             celular = :celular, email = :email,
                                             nascimento = :nascimento, cidade = :cidade');
            $salvar->bindValue(":nome", $_POST['nome'], PDO::PARAM_STR);
            $salvar->bindValue(":sexo", $_POST['sexo'], PDO::PARAM_STR);
            $salvar->bindValue(":pai", $_POST['pai'], PDO::PARAM_STR);
            $salvar->bindValue(":mae", $_POST['mae'], PDO::PARAM_STR);
            $salvar->bindValue(":endereco", $_POST['endereco'], PDO::PARAM_STR);
            $salvar->bindValue(":bairro", $_POST['bairro'], PDO::PARAM_STR);
            $salvar->bindValue(":cep", $_POST['cep'], PDO::PARAM_STR);
            $salvar->bindValue(":cidade", $_POST['cidade'], PDO::PARAM_STR);
            $salvar->bindValue(":uf", $_POST['uf'], PDO::PARAM_STR);
            $salvar->bindValue(":telefone", $_POST['telefone'],PDO::PARAM_STR );
            $salvar->bindValue(":celular", $_POST['celular'],PDO::PARAM_STR);
            $salvar->bindValue(":email", $_POST['email'], PDO::PARAM_STR);
            $salvar->bindValue(":nascimento", formatarData($_POST['nascimento'], 'US'), PDO::PARAM_STR);
            $salvar->execute();
        } catch (PDOException $exception) {
            echo json_encode(array("sucesso" => false, "dados" => $exception->getMessage()));
            exit();
        }
        echo json_encode(array("sucesso" => true, "dados" => "Dados salvos com sucesso"));
        break;

    case 'atualizar':
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

        $atualizar->bindValue(":id", (int)$_POST['id'], PDO::PARAM_INT);
        $atualizar->bindValue(":nome", $_POST['nome'], PDO::PARAM_STR);
        $atualizar->bindValue(":sexo", $_POST['sexo'], PDO::PARAM_STR);
        $atualizar->bindValue(":nascimento", formatarData($_POST['nascimento'], 'US'), PDO::PARAM_STR);
        $atualizar->bindValue(":pai", $_POST['pai'], PDO::PARAM_STR);
        $atualizar->bindValue(":mae", $_POST['mae'], PDO::PARAM_STR);
        $atualizar->bindValue(":endereco", $_POST['endereco'], PDO::PARAM_STR);
        $atualizar->bindValue(":bairro", $_POST['bairro'], PDO::PARAM_STR);
        $atualizar->bindValue(":cep", $_POST['cep'], PDO::PARAM_STR);
        $atualizar->bindValue(":cidade", $_POST['cidade'], PDO::PARAM_STR);
        $atualizar->bindValue(":uf", $_POST['uf'], PDO::PARAM_STR);
        $atualizar->bindValue(":telefone", $_POST['telefone'], PDO::PARAM_STR);
        $atualizar->bindValue(":celular", $_POST['celular'], PDO::PARAM_STR);
        $atualizar->bindValue(":email", $_POST['email'], PDO::PARAM_STR);
        $atualizar->execute();
        break;

    case 'listar':
        $db = Banco::getConnection();
        $sql = "SELECT * FROM pessoa WHERE id {$filter} ORDER BY nome";
        $buscarPessoa = $db->prepare($sql);
        $buscarPessoa->execute($bindParams);
        $dadosPessoa = $buscarPessoa->fetchAll(PDO::FETCH_OBJ);
        break;

    case 'excluir':
        $db = Banco::getConnection();
        $sql = 'DELETE FROM pessoa WHERE id = :id';
        $excluir = $db->prepare($sql);
        $excluir->bindValue(":id", $_POST['id']);
        $excluir->execute();
        break;

    case 'getById':
        try {
            $db = Banco::getConnection();
            $sql = "SELECT * FROM pessoa WHERE id = :id";
            $buscarPessoa = $db->prepare($sql);
            $buscarPessoa->bindValue(":id", $_POST['id']);
            $buscarPessoa->execute();
            $dadosPessoa = $buscarPessoa->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            echo json_encode(array("sucesso" => false, "dados" => $exception->getMessage()));
            exit();
        }
        echo json_encode(array("sucesso" => true, "dados" => $dadosPessoa));
        break;


    case 'filtro':
        $sql = "SELECT * FROM pessoa WHERE id {$filter} ORDER BY nome";
        $buscarDadosPessoa = $db->prepare($sql);
        $buscarDadosPessoa->execute($bindParams);
        $dadosPessoa = $buscarDadosPessoa->fetchAll(PDO::FETCH_OBJ);
        break;
    default:
        die('acao nao identificada: '.$acao);
        break;
}