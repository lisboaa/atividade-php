<?php


require 'conexao.php';
$modoEdicao = false;
$dadoPessoa = [];
$db = Banco::getConnection();

 function formatarData($data, $formato) {
     switch ($formato) {
         case 'BR':
             return implode('/', array_reverse(explode('-', $data)));
         case 'US':
             return implode('-', array_reverse(explode('/', $data)));
     }
     return false;
 }

 function getEndereco($cep) {
     $cep = preg_replace("/[^0-9]/", "", $cep);
     $url = "http://viacep.com.br/ws/$cep/xml/";
     $xml = simplexml_load_file($url);
     return $xml;
 }

//var_dump($_POST); die(0);

 if (isset($_POST['acao']) && $_POST['acao'] == 'gravar') {
     $db = Banco::getConnection();
     $salvar = $db->prepare('INSERT INTO pessoa SET nome = :nome, 
                                                              sexo = :sexo,
                                                              pai = :pai,
                                                              mae = :mae,
                                                              endereco = :endereco,
                                                              bairro = :bairro,
                                                              cep = :cep,
                                                              uf = :uf,
                                                              telefone = :telefone,
                                                              celular = :celular,
                                                              email = :email,
                                                              nascimento = :nascimento,
                                                              cidade = :cidade');
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
     header("Location: listagemPessoa.php");
     exit();

 } elseif (isset($_POST['acao']) && $_POST['acao'] == 'atualizar') {
     if (empty($_POST['id'])) {
         die('Não foi possive realizar a altaeração do dado');
     }
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
     header("Location: listagemPessoa.php");
     exit();
 }

 if (isset($_GET['id']) && (int) $_GET['id'] > 0) {
     $modoEdicao = true;
     try {
         $db = Banco::getConnection();
         $sql = "SELECT * FROM pessoa WHERE id = :id";
         $buscarPessoa = $db->prepare($sql);
         $buscarPessoa->bindValue(":id", $_GET['id']);
         $buscarPessoa->execute();
         $dadosPessoa = $buscarPessoa->fetch(PDO::FETCH_ASSOC);
     } catch (PDOException $exception) {
        echo $exception->getMessage();
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
<h2></h2>
    <form action="formPessoa.php" method="POST">
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
        <button type="submit">Enviar</button>
    </form>

<script>

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
