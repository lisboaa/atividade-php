<?php
//require 'formPessoa.php';
require 'conexao.php';
$db = Banco::getConnection();
$filter = '';

function dataFormat($data, $format) {
    switch ($format) {
        case 'BR':
            return implode('/', array_reverse(explode('-', $data)));
        case 'US':
            return implode('-', array_reverse(explode('/', $data)));
    }
    return '';
}


try {
    if (isset($_POST['acao']) && $_POST['acao'] == 'excluir' && $_POST['id'] > 0) {
        $sql = "DELETE FROM pessoa WHERE id = :id";
        $excluir = $db->prepare($sql);
        $excluir->bindValue(":id", $_POST['id']);
        $excluir->execute();
    }
} catch (PDOException $exception) {
    echo $exception->getMessage();
}



$bindParams = [];
if (isset($_GET['buscarnome']) and !empty($_GET['buscarnome'])) {
    $bindParams[':buscarnome'] = "%{$_GET['buscarnome']}%";
    $filter .= " AND nome LIKE :buscarnome";
}
if (isset($_GET['buscarnascimento']) and !empty($_GET['buscarnascimento'])) {
    $dataFormatada =  dataFormat($_GET['buscarnascimento'],'US');
    $bindParams[':buscarnascimento'] = $dataFormatada;
    $filter .= " AND nascimento = :buscarnascimento";
}
if (isset($_GET['buscarmesnascimento']) and !empty($_GET['buscarmesnascimento'])) {
    $bindParams[':buscarmesnascimento'] = $_GET['buscarmesnascimento'];
    $filter .= " AND MONTH(nascimento) = :buscarmesnascimento";
}

try {
    $sql = "SELECT * FROM pessoa WHERE id {$filter} ORDER BY nome";
    $buscarDadosPessoa = $db->prepare($sql);
    $buscarDadosPessoa->execute($bindParams);
    $dadosPessoa = $buscarDadosPessoa->fetchAll(PDO::FETCH_OBJ);
} catch (PDOException $exception) {
    echo $exception->getMessage();
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
<form method="GET" action="listagemPessoa.php">
    <input type="text" name="buscarnome">
    <input type="text" name="buscarnascimento" placeholder="Buscar por data de nascimento">
    <input type="number" min="1" max="12" maxlength="2" name="buscarmesnascimento" placeholder="Buscar por mes do nascimento">
    <button type="submit">Buscar</button>
</form>
<table border="1">
    <tr>
        <th>Nome</th>
        <th>Pai</th>
        <th>Sexo</th>
        <th>Mae</th>
        <th>Endereco</th>
        <th>Bairro</th>
        <th>Cep</th>
        <th>Uf</th>
        <th>Cidade</th>
        <th>Telefone</th>
        <th>Nascimento</th>
    </tr>
    </tr>
        <? foreach ($dadosPessoa as $dados) {?>
            <tr>
                <td><? echo $dados->nome?></td>
                <td><? echo $dados->pai?></td>
                <td><? echo $dados->sexo?></td>
                <td><? echo $dados->mae?></td>
                <td><? echo $dados->endereco?></td>
                <td><? echo $dados->bairro?></td>
                <td><? echo $dados->cep?></td>
                <td><? echo $dados->uf?></td>
                <td><? echo $dados->cidade?></td>
                <td><? echo $dados->telefone?></td>
                <td><? echo dataFormat($dados->nascimento, 'BR')?></td>
                <td><a href="formPessoa.php?id=<? echo $dados->id ?>" >Editar</a></td>
                <td>
                    <form action="listagemPessoa.php" method="POST">
                        <input type="hidden" name="id" value="<?php echo $dados->id ?>">
                        <input type="hidden" name="acao" value="excluir">
                        <button type="submit">Excluir</button>
                    </form>
                </td>
            </tr>
        <?}?>
    </table>
</body>
</html>
