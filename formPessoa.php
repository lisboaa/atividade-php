<?php
$modoEdicao = false;
$dadoPessoa = [];


//var_dump($_REQUEST['id']);die(0);
 function formatarData($data, $formato) {
     switch ($formato) {
         case 'BR':
             return implode('/', array_reverse(explode('-', $data)));
         case 'US':
             return implode('-', array_reverse(explode('/', $data)));
     }
     return false;
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
<h2></h2>
    <form id="formulario">
        <input type="hidden" id="id" name="id" value="">
        <label>Nome:</label>
        <input name="nome" id="nome" value="" type="text"><br><br>
        <label>Nascimento:</label>
        <input name="nascimento" id="nascimento" value="" type="text"><br><br>
        <label>Pai:</label>
        <input name="pai" id="pai" value="" type="text"><br><br>
        <label>Mae:</label>
        <input name="mae" id="mae" value="" type="text"><br><br>
        <label>Endereço:</label>
        <input id="rua" name="endereco" value="" type="text"><br><br>
        <label>Bairro:</label>
        <input id="bairro" name="bairro" value="" type="text"><br><br>
        <label>Cep:</label>
        <input id="cep" size="10" maxlength="9" name="cep" value="" type="text"><br><br>
        <label>Cidade:</label>
        <input id="cidade" name="cidade" value="" type="text"><br><br>
        <label>Uf:</label>
        <input id="uf" name="uf" value="" type="text"><br><br>
        <label>Telefone:</label>
        <input id="telefone" name="telefone" value="" type="text"><br><br>
        <label>Celular:</label>
        <input name="celular" id="celular" value="" type="text"><br><br>
        <label>Email:</label>
        <input name="email" id="email" value="" type="text"><br><br>

        <label>Sexo:</label>
        <select name="sexo" id="sexo">
            <option></option>
            <option value="M">Masculino</option>
            <option value="F">Feminino</option>
        </select><br><br>
        <button type="submit">Enviar</button>
        <button onclick="voltar()">Voltar</button>
    </form>

<script>
    const url = window.location.href;
    const valorUrl = new URL(url);
    const paramId = valorUrl.searchParams.get("id");

    if(paramId > 0){
        editar(paramId);
    }

    function editar(paramId) {
        const data = new FormData();
        data.set('acao', 'getById');
        data.set('id', paramId);

        fetch('pessoacontroller.php', {
            method: 'post',
            body: data
        }).then((response) => {
            return response.json();
        }).then((response) => {
            document.getElementById("id").value=(response.dados.id);
            document.getElementById("nome").value=(response.dados.nome);
            document.getElementById("nascimento").value=(response.dados.nascimento);
            document.getElementById("bairro").value=(response.dados.bairro);
            document.getElementById("cep").value=(response.dados.cep);
            document.getElementById("rua").value=(response.dados.endereco);
            document.getElementById("pai").value=(response.dados.pai);
            document.getElementById("mae").value=(response.dados.mae);
            document.getElementById("cidade").value=(response.dados.cidade);
            document.getElementById("uf").value=(response.dados.uf);
            document.getElementById("telefone").value=(response.dados.telefone);
            document.getElementById("celular").value=(response.dados.celular);
            document.getElementById("email").value=(response.dados.email);
            document.getElementById("sexo").value=(response.dados.sexo);
        }).catch((error) => {
            console.log(error);
        })
    }


    document.getElementById('formulario').addEventListener("submit", (e) => {
        e.preventDefault();
        Teste();
    })

    function Teste() {
        if (paramId > 0) {
            atualizar()
            console.log("Atualizou");
            return true;
        } else {
            Salvar();
            console.log("Salvou");
            return false;
        }
    }

    function atualizar() {
        const formulario = document.getElementById('formulario');
        const dadosformulario = new FormData(formulario);

        dadosformulario.set('acao', 'atualizar');

        fetch('pessoacontroller.php', {
            method: 'post',
            body: dadosformulario
        }).then((response) => {
            return response.json();
        }).then((response) => {
            console.log(response);
            alert(response.dados);
            if (response.sucesso) {
                window.location.href = "listagemPessoa.php";
            }
        }).catch((error) => {
            console.log(error);
        })
    }

    function voltar() {
        window.location.href = "listagemPessoa.php";
    }

    function Salvar() {
        const formulario = document.getElementById('formulario');
        const dadosFormulario = new FormData(formulario);

        fetch('pessoacontroller.php', {
            method: 'post',
            body: dadosFormulario
        }).then((response) => {
            return response.json();
        }).then((response) => {
            alert(response.dados);
            if(response.sucesso) {
                location.href = 'listagemPessoa.php';
            }
            console.log(response);
        }).catch((error) => {
            console.log(error);
        })
    }

    document.getElementById("cep").addEventListener("blur", function(event) {
        pesquisacep(this.value);
    });

    function limpa_formulário_cep() {
        //Limpa valores do formulário de cep.
        document.getElementById('rua').value=("");
        document.getElementById('bairro').value=("");
        document.getElementById('cidade').value=("");
        document.getElementById('uf').value=("");
    }

    function meu_callback(conteudo) {
        if ("erro" in conteudo){
            alert("CEP não encontrado.");
            return;
        }

        //Atualiza os campos com os valores.
        document.getElementById('rua').value=(conteudo.logradouro);
        document.getElementById('bairro').value=(conteudo.bairro);
        document.getElementById('cidade').value=(conteudo.localidade);
        document.getElementById('uf').value=(conteudo.uf);
    }

    function pesquisacep(valor) {

        //Nova variável "cep" somente com dígitos.
        var cep = valor.replace(/\D/g, '');

        //Verifica se campo cep possui valor informado.
        if(!cep){
            return;
        }

        //Expressão regular para validar o CEP.
        var validacep = /^[0-9]{8}$/;

        //Valida o formato do CEP.
        if(!validacep.test(cep)) {
            alert("Formato de CEP inválido.");
            return;
        }

        //Preenche os campos com "..." enquanto consulta webservice.
        document.getElementById('rua').value="...";
        document.getElementById('bairro').value="...";
        document.getElementById('cidade').value="...";
        document.getElementById('uf').value="...";

        //Cria um elemento javascript.
        var script = document.createElement('script');

        //Sincroniza com o callback.
        script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback';

        //Insere script no documento e carrega o conteúdo.
        document.body.appendChild(script);
    };

</script>
</body>
</html>
