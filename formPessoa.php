<?php

ini_set('display_errors', true);
error_reporting(E_ALL);

require 'conexao.php';

$db = Banco::getConnection();
$dadosPessoa = [];
$mododoEdicao = false;

function dataFormat($data, $format) {
    switch ($format) {
        case 'BR':
            return implode('/', array_reverse(explode('-', $data)));
        case 'US':
            return implode('-', array_reverse(explode('/', $data)));
    }
    return '';
}

if (isset($_POST['acao']) && $_POST['acao'] == 'gravar') {


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
    $salvar->bindValue(":nascimento", dataFormat($_POST['nascimento'], 'US'), PDO::PARAM_STR);
    $salvar->execute();
    header("Location: listagemPessoa.php");
    exit();
}
else if (isset($_POST['acao']) && $_POST['acao'] == 'atualizar') {
    if(empty($_POST['id'])){
        die('Registro não identificado para atualização');
    }
    $db = Banco::getConnection();
    $atualizar = $db->prepare('UPDATE pessoa SET nome = :nome, 
                                                sexo = :sexo, pai = :pai, mae = :mae,
                                        endereco = :endereco, bairro = :bairro, cep = :cep, uf = :uf,
                                         celular = :celular, telefone = :telefone, celular = :celular, email = :email,
                                         nascimento = :nascimento, cidade = :cidade WHERE id = :id');
    $atualizar->bindValue(":id", (int)$_POST['id'], PDO::PARAM_INT);
    $atualizar->bindValue(":nome", $_POST['nome'], PDO::PARAM_STR);
    $atualizar->bindValue(":sexo", $_POST['sexo'], PDO::PARAM_STR);
    $atualizar->bindValue(":pai", $_POST['pai'], PDO::PARAM_STR);
    $atualizar->bindValue(":mae", $_POST['mae'], PDO::PARAM_STR);
    $atualizar->bindValue(":endereco", $_POST['endereco'], PDO::PARAM_STR);
    $atualizar->bindValue(":bairro", $_POST['bairro'], PDO::PARAM_STR);
    $atualizar->bindValue(":cep", $_POST['cep'], PDO::PARAM_STR);
    $atualizar->bindValue(":cidade", $_POST['cidade'], PDO::PARAM_STR);
    $atualizar->bindValue(":uf", $_POST['uf'], PDO::PARAM_STR);
    $atualizar->bindValue(":telefone", $_POST['telefone'],PDO::PARAM_STR );
    $atualizar->bindValue(":celular", $_POST['celular'],PDO::PARAM_STR);
    $atualizar->bindValue(":email", $_POST['email'], PDO::PARAM_STR);
    $atualizar->bindValue(":nascimento", dataFormat($_POST['nascimento'], 'US'), PDO::PARAM_STR);
    $atualizar->execute();
    header("Location: listagemPessoa.php");
    exit();
}

if (isset($_GET['id']) && (int)$_GET['id'] > 0 ) {
    $mododoEdicao = true;
    try {
        $db = Banco::getConnection();
        $buscar = $db->prepare('SELECT * FROM pessoa WHERE id = :id');
        $buscar->bindValue(":id", (int)$_GET['id'], PDO::PARAM_INT);
        $buscar->execute();
        if(!$buscar->rowCount()) {
            die('Registro não encontrado');
        }
        $dadosPessoa = $buscar->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $exception) {
        die($exception->getMessage());
    }
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Atividade PHP</title>
</head>
<body>
    <h1></h1>
<form action="formPessoa.php" method="POST">
    <input type="hidden" name="acao" value="<?php echo ($mododoEdicao) ? 'atualizar' : 'gravar' ?>">
    <input type="hidden" name="id" value="<?php if ($mododoEdicao) { echo $dadosPessoa['id']; } ?>">
    <label>Nome</label><br>
    <input value="<?php if ($mododoEdicao) { echo $dadosPessoa['nome']; } ?>" name="nome"><br>

    <label>Sexo</label><br>
    <select name="sexo">
        <option></option>
        <option value="F"<?php if( $mododoEdicao && $dadosPessoa['sexo'] == 'F' ) { echo 'selected';}?>>Feminino</option>
        <option value="M"<?php if( $mododoEdicao && $dadosPessoa['sexo'] == 'M' ) { echo 'selected';}?>>Masculino</option>
    </select><br>

    <label>Pai</label><br>
    <input value="<?php if ($mododoEdicao) { echo $dadosPessoa['pai']; } ?>" name="pai"><br>

    <label>Mae</label><br>
    <input value="<?php if ($mododoEdicao) { echo $dadosPessoa['mae']; } ?>" name="mae"><br>

    <label>Endereco</label><br>
    <input value="<?php if ($mododoEdicao) { echo $dadosPessoa['endereco']; } ?>" name="endereco"><br>

    <label>Bairro</label><br>
    <input value="<?php if ($mododoEdicao) { echo $dadosPessoa['bairro']; } ?>" name="bairro"><br>

    <label>Cep</label><br>
    <input value="<?php if ($mododoEdicao) { echo $dadosPessoa['cep']; } ?>" name="cep"><br>

    <label>Cidade</label><br>
    <input value="<?php if ($mododoEdicao) { echo $dadosPessoa['cidade']; } ?>" name="cidade"><br>

    <label>Uf</label><br>
    <input value="<?php if ($mododoEdicao) { echo $dadosPessoa['uf']; } ?>" name="uf"><br>

    <label>Telefone</label><br>
    <input value="<?php if ($mododoEdicao) { echo $dadosPessoa['telefone']; } ?>" name="telefone"><br>

    <label>Celular</label><br>
    <input value="<?php if ($mododoEdicao) { echo $dadosPessoa['celular']; } ?>" name="celular"><br>

    <label>Email</label><br>
    <input value="<?php if ($mododoEdicao) { echo $dadosPessoa['email']; } ?>" name="email"><br>

    <label>Data de Nascimento</label><br>
    <input value="<?php if ($mododoEdicao) { echo dataFormat($dadosPessoa['nascimento'], 'BR'); } ?>" name="nascimento"><br>

    <button type="submit">Enviar</button>
</form>
</body>
</html>
