<?php

require 'conexao.php';
$filter = '';

//function formatarData($data, $format) {
//    switch ($format) {
//        case 'BR':
//            return implode('/', array_reverse(explode('-', $data)));
//        case 'US':
//            return implode('-', array_reverse(explode('/', $data)));
//    }
//    return '';
//}

//$bindParams = [];
//if (isset($_GET['buscarnome']) and !empty($_GET['buscarnome'])) {
//    $bindParams[':buscarnome'] = "%{$_GET['buscarnome']}%";
//    $filter .= " AND nome LIKE :buscarnome";
//}
//if (isset($_GET['buscarnascimento']) and !empty($_GET['buscarnascimento'])) {
//    $dataFormatada =  formatarData($_GET['buscarnascimento'],'US');
//    $bindParams[':buscarnascimento'] = $dataFormatada;
//    $filter .= " AND nascimento = :buscarnascimento";
//}
//if (isset($_GET['buscarmesnascimento']) and !empty($_GET['buscarmesnascimento'])) {
//    $bindParams[':buscarmesnascimento'] = $_GET['buscarmesnascimento'];
//    $filter .= " AND MONTH(nascimento) = :buscarmesnascimento";
//}

//try {
//    $db = Banco::getConnection();
//    $sql = "SELECT * FROM pessoa WHERE id {$filter} ORDER BY nome";
//    $buscarDadosPessoa = $db->prepare($sql);
//    $buscarDadosPessoa->execute($bindParams);
//    $dadosPessoa = $buscarDadosPessoa->fetchAll(PDO::FETCH_OBJ);
//} catch (PDOException $exception) {
//    echo $exception->getMessage();
//}


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
<form method="GET" action="listagemPessoa.php" id="formulario">
    <input type="text" name="buscarnome">
    <input type="text" name="buscarnascimento" placeholder="Buscar por data de nascimento">
    <input type="number" min="1" max="12" maxlength="2" name="buscarmesnascimento" placeholder="Buscar por mes do nascimento">
    <button type="submit">Buscar</button>
</form>
    <table border="1" id="idTabela">
        <thead>
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
                <th>Ações</th>
            </tr>
        </thead>
        <tbody id="tbody">
        </tbody>
            <button onclick="criarElementos()">Criar</button>
    </table>
<script>

    // document.getElementById('excluir');
//    const valorId = document.getElementById('id').value;

    // document.getElementById('formulario').addEventListener('submit', (event) => {
    //     event.preventDefault();
    //     excluir();
    //     criarTabela();
    // })

    function excluir() {
        if (valorId > 0) {
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
    
    listar();
    function listar() {
        const dadosTabela = new FormData();
        dadosTabela.set('acao', 'listar');
        // dadosFormulario.set('acao', 'listar');
        // const tabela = document.getElementById('idTabela');
        // const dadosTebela = new Set()
        // dadosTebela.add('acao', 'listar')
        // console.log('valor da acao' + dadosTebela);
        fetch('pessoacontroller.php', {
            method: 'post',
            body: dadosTabela
        }).then((response) => {
            return response.json()
        }).then((response) => {
            console.log(response)
            response.dados.forEach(function(pessoa) {
                criarElementos(pessoa);
            })
        }).catch((error) => {
            console.log(error);
        })
    }


    function criarElementos(pessoa) {

        const tr = document.createElement("tr");

        const td1 = document.createElement("td");
        td1.append(pessoa.nome);
        tr.appendChild(td1);

        const td2 = document.createElement("td");
        td2.append('asoidoaios');
        tr.appendChild(td2);

        const td3 = document.createElement("td");
        const linkEditar = document.createElement('a');
        linkEditar.setAttribute('href', 'formPessoa.php?id=' + pessoa.id)
        linkEditar.append('editar');
        td3.appendChild(linkEditar);
        tr.appendChild(td3);

        document.getElementById('tbody').append(tr);


        // const td = document.createElement("TD");
        // const texto = document.createTextNode("Valor do campo");
        // td.appendChild(texto);
        // document.getElementById("tbody").appendChild(td);
        //
        // const buttonExcuir = document.createElement('BUTTON');
        // const textoBotao = document.createTextNode('Excluir');
        // buttonExcuir.appendChild(textoBotao)
        // document.getElementById("tbody").appendChild(buttonExcuir);
        //
        //
        // const buttonEditar = document.createElement('BUTTON');
        // const textoBotaoEditar = document.createTextNode('Editar');
        // buttonEditar.appendChild(textoBotaoEditar);
        // document.getElementById("tbody").appendChild(buttonEditar);
    }
</script>
</body>
</html>
