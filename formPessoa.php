<?php
$modoEdicao = false;
$dadoPessoa = [];

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
    <form method="POST" id="formulario">
        <input type="hidden" name="acao" value="<?php echo ($modoEdicao) ? 'atualizar' : 'gravar' ?>">
        <input type="hidden" name="id" value="<?php if ($modoEdicao) { echo $dadosPessoa['id']; } ?>">
        <label>Nome:</label>
        <input name="nome" value="<?php if ($modoEdicao) { echo $dadosPessoa['nome']; } ?>" type="text"><br><br>
        <label>Nascimento:</label>
        <input name="nascimento" value="<?php if ($modoEdicao) { echo formatarData($dadosPessoa['nascimento'],'BR'); } ?>" type="text"><br><br>
        <label>Pai:</label>
        <input name="pai" value="<?php if($modoEdicao) { echo $dadosPessoa['pai'];}?>" type="text"><br><br>
        <label>Mae:</label>
        <input name="mae" value="<?php if ($modoEdicao) { echo $dadosPessoa['mae'];}?>" type="text"><br><br>
        <label>Endereço:</label>
        <input id="rua" name="endereco" value="<?php if ($modoEdicao) { echo $dadosPessoa['endereco'];}?>" type="text"><br><br>
        <label>Bairro:</label>
        <input id="bairro" name="bairro" value="<?php if ($modoEdicao) { echo $dadosPessoa['bairro'];}?>" type="text"><br><br>
        <label>Cep:</label>
        <input id="cep" size="10" maxlength="9" name="cep" value="<?php if ($modoEdicao) { echo $dadosPessoa['cep'];}?>" type="text"><br><br>
        <label>Cidade:</label>
        <input id="cidade" name="cidade" value="<?php if ($modoEdicao) { echo $dadosPessoa['cidade'];}?>" type="text"><br><br>
        <label>Uf:</label>
        <input id="uf" name="uf" value="<?php if ($modoEdicao) { echo $dadosPessoa['uf'];}?>" type="text"><br><br>
        <label>Telefone:</label>
        <input id="telefone" name="telefone" value="<?php if ($modoEdicao) { echo $dadosPessoa['telefone'];}?>" type="text"><br><br>
        <label>Celular:</label>
        <input name="celular" value="<?php if ($modoEdicao) { echo $dadosPessoa['celular'];}?>" type="text"><br><br>
        <label>Email:</label>
        <input name="email" value="<?php if ($modoEdicao) { echo $dadosPessoa['email'];}?>" type="text"><br><br>

        <label>Sexo:</label>
        <select name="sexo">
            <option></option>
            <option value="M" <?php if ($modoEdicao && $dadosPessoa['sexo'] == 'M') { echo 'selected'; }?>>Masculino</option>
            <option value="F" <?php if ($modoEdicao && $dadosPessoa['sexo'] == 'F') { echo 'selected'; }?>>Feminino</option>
        </select><br><br>
        <label>Sexo</label><br>
        <button type="submit" onclick="Salvar()">Enviar</button>
    </form>

<script>
    function Salvar() {
        const formulario = document.getElementById('formulario');
        formulario.addEventListener('submit', function (event) {
            event.preventDefault();

            const dadosFormulario = new FormData(this);

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
