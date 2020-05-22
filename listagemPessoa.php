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
<form id="formulario">
    <input type="text" name="buscarnome">
    <input type="text" name="buscarnascimento" placeholder="Buscar por data de nascimento">
    <input type="number" min="1" max="12" maxlength="2" name="buscarmesnascimento" placeholder="Buscar por mes do">
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
    </table>

<script>

    function formatarData(data, formato) {
        switch (formato) {
            case 'BR':
                return data.split('-').reverse().join('/');
            break;

            case 'US':
                return date.split('/').reverse().join('-');
        }
        return '';
    }

    function excluir(id)
    {
        if(!(id >= 0)){
            alert('Não foi possivel realizar a exclusão do iten solicitado');
            return
        }

        const data = new FormData();
        data.set('acao', 'excluir');
        data.set('id',id);

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

    }

   listar();

   document.getElementById('formulario').addEventListener("submit", (e) => {
       e.preventDefault();
       document.getElementById('tbody').innerHTML = '';
       listar();
   })

    function listar() {
        const dadosForm = document.getElementById('formulario');
        const dadosBusca = new FormData(dadosForm);
        dadosBusca.set('acao', 'listar');
        fetch('pessoacontroller.php', {
            method: 'post',
            body: dadosBusca
        }).then((response) => {
            return response.json();
        }).then((response) => {
            /*
            * percorre os dados referente a query e cria elementos nativos da tabela (tr, td etc...)
            * */
            response.dados.forEach(function(pessoa) {
                criarElementos(pessoa);
            })
            console.log(response);
        }).catch((error) => {
            console.log(error);
        })
    }

    function adicionarPessoa() {
        const idFormulario = document.getElementById('formulario');
        const novoBotao = document.createElement('button');
        novoBotao.setAttribute('onclick','adicionarPessoa()');
        novoBotao.setAttribute('style','margin-left: 10px;');
        novoBotao.setAttribute('id','adicionar');
        novoBotao.append('Adicionar Pessoa');
        idFormulario.appendChild(novoBotao);
        window.location.href = "formPessoa.php";
    }

    function criarElementos(pessoa) {

        const tr = document.createElement("tr");

        const td1 = document.createElement("td");
        td1.append(pessoa.nome);
        tr.appendChild(td1);

        const td2 = document.createElement("td");
        td2.append(formatarData(pessoa.nascimento, 'BR'));
        tr.appendChild(td2);

        const td4 = document.createElement("td");
        td4.append(pessoa.pai);
        tr.appendChild(td4);

        const td5 = document.createElement("td");
        td5.append(pessoa.mae);
        tr.appendChild(td5);

        const td6 = document.createElement("td");
        td6.append(pessoa.endereco);
        tr.appendChild(td6);

        const td7 = document.createElement("td");
        td7.append(pessoa.bairro);
        tr.appendChild(td7);

        const td8 = document.createElement("td");
        td8.append(pessoa.cep);
        tr.appendChild(td8);

        const td9 = document.createElement("td");
        td9.append(pessoa.cidade);
        tr.appendChild(td9);

        const td10 = document.createElement("td");
        td10.append(pessoa.uf);
        tr.appendChild(td10);

        const td11 = document.createElement("td");
        td11.append(pessoa.telefone);
        tr.appendChild(td11);

        const td12 = document.createElement("td");
        td12.append(pessoa.celular);
        tr.appendChild(td12);

        const td13 = document.createElement("td");
        td13.append(pessoa.email);
        tr.appendChild(td13);

        const td14 = document.createElement("td");
        td14.append(pessoa.sexo);
        tr.appendChild(td14);

        const td3 = document.createElement("td");
        const linkEditar = document.createElement('a');
        linkEditar.setAttribute('href', 'formPessoa.php?id=' + pessoa.id);
        linkEditar.append('Editar');
        td3.appendChild(linkEditar);
        tr.appendChild(td3);

        const td15 = document.createElement("td");
        const botaoExcluir = document.createElement('button');
        botaoExcluir.setAttribute('value', pessoa.id);
        botaoExcluir.setAttribute('type', 'button');
        botaoExcluir.setAttribute('onclick', 'excluir('+pessoa.id+')');
        botaoExcluir.append('Excluir');
        td15.appendChild(botaoExcluir);
        tr.appendChild(td15);

        document.getElementById('tbody').append(tr);
    }
</script>
</body>
</html>
