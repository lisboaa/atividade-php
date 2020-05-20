<?php

require 'conexao.php';
$filter = '';

function formatarData($data, $format) {
    switch ($format) {
        case 'BR':
            return implode('/', array_reverse(explode('-', $data)));
        case 'US':
            return implode('-', array_reverse(explode('/', $data)));
    }
    return '';
}

$bindParams = [];
if (isset($_GET['buscarnome']) and !empty($_GET['buscarnome'])) {
    $bindParams[':buscarnome'] = "%{$_GET['buscarnome']}%";
    $filter .= " AND nome LIKE :buscarnome";
}
if (isset($_GET['buscarnascimento']) and !empty($_GET['buscarnascimento'])) {
    $dataFormatada =  formatarData($_GET['buscarnascimento'],'US');
    $bindParams[':buscarnascimento'] = $dataFormatada;
    $filter .= " AND nascimento = :buscarnascimento";
}
if (isset($_GET['buscarmesnascimento']) and !empty($_GET['buscarmesnascimento'])) {
    $bindParams[':buscarmesnascimento'] = $_GET['buscarmesnascimento'];
    $filter .= " AND MONTH(nascimento) = :buscarmesnascimento";
}

try {
    $db = Banco::getConnection();
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
    <title>Document</title>
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
            <th>Nascimento</th>
            <th>Pai</th>
            <th>Mae</th>
            <th>Endereco</th>
            <th>Bairro</th>
            <th>Cep</th>
            <th>Cidade</th>
            <th>Uf</th>
            <th>Telefone</th>
            <th>Celular</th>
            <th>Email</th>
            <th>Sexo</th>
        </tr>

            <?php foreach ($dadosPessoa as $dados) {?>
                <tr>
                    <td><?php echo $dados->nome?></td>
                    <td><?php echo formatarData($dados->nascimento, 'BR')?></td>
                    <td><?php echo $dados->pai?></td>
                    <td><?php echo $dados->mae?></td>
                    <td><?php echo $dados->endereco?></td>
                    <td><?php echo $dados->bairro?></td>
                    <td><?php echo $dados->cep?></td>
                    <td><?php echo $dados->cidade?></td>
                    <td><?php echo $dados->uf?></td>
                    <td><?php echo $dados->telefone?></td>
                    <td><?php echo $dados->celular?></td>
                    <td><?php echo $dados->email?></td>
                    <td><?php echo $dados->sexo?></td>
                    <td><a id="editar" href="formPessoa.php?id=<? echo $dados->id ?>">Editar</a></td>
                    <td>
                        <form action="listagemPessoa.php" id="formulario">
                            <input type="hidden" name="id" id="id" value="<?php echo $dados->id ?>">
                            <input type="hidden" name="acao" value="excluir">
                            <button id="excluir" type="submit">Excluir</button>
                        </form>
                    </td>
                <tr>
            <?}?>
    </table>
<script>

    document.getElementById('excluir');
    const valorId = document.getElementById('id').value;

    document.getElementById('formulario').addEventListener('submit', (event) => {
        event.preventDefault();
        window.onload;
        excluir();
    })

    function excluir() {
        if (valorId > 0) {
            const formulario = document.getElementById('formulario');
            const data = new FormData(formulario);
            const valorId = document.getElementById('id').value;

            data.set('acao', 'excluir');
            data.set('id',valorId);

            fetch('pessoacontroller.php', {
                method: 'post',
                body: data
            }).then((response) => {
                return response.json();
            }).then((response) => {
                console.log(response);
                listar();
            }).catch((error) => {
                console.log(error);
            })
        } else {
            alert('Não foi possivel realizar a exclusão do iten solicitado');
        }
    }

    function listar() {
        // asdasdasd
    }
</script>
</body>
</html>
