
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
        <label>Cep:</label>
        <input name="cep" type="text" id="cep" value="" size="10" maxlength="9" onblur="pesquisacep(this.value);"><br><br>
        <label>Endereço:</label>
        <input id="rua" name="endereco" value="" type="text"><br><br>
        <label>Bairro:</label>
        <input id="bairro" name="bairro" value="" type="text"><br><br>
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

    document.getElementById('formulario').addEventListener('submit', function (event) {
        event.preventDefault();
        atualizarDadosEdicao()
    })

        /*
        * Faz a busca do id referente ao iten selecionado.
        * */
        const url = window.location.href;
        const valorDaUrl = new URL(url);
        const paramId = valorDaUrl.searchParams.get('id');

        if (paramId > 0) {
            editar();
        }

        function atualizarDadosEdicao() {
            if (paramId > 0) {
                atualizar();
                console.log('Atualizar');
            } else {
                salvar('Dados salvo com sucesso');
                console.log('Salvar');
            }
        }
/*
* Faz a busca referente ao id da pessoa retornando seus dados preenchidos na tela.
* */
    function editar(paramId) {
        const dadosFormulario = document.getElementById('formulario');
        const dados = new FormData(dadosFormulario);
        dados.set('acao', 'getById');
        dados.set('id', paramId);

        fetch('pessoacontroller.php', {
            method: 'post',
            body: dados
        }).then((response) => {
            return response.json();
        }).then((response) => {
            console.log(response);
            document.getElementById('nome').value = (response.dados.nome);
            document.getElementById('nascimento').value = (formatarData(response.dados.nascimento, 'BR'));
            document.getElementById('pai').value = (response.dados.pai);
            document.getElementById('mae').value = (response.dados.mae);
            document.getElementById('cep').value = (response.dados.cep);
            document.getElementById('rua').value = (response.dados.endereco);
            document.getElementById('bairro').value = (response.dados.bairro);
            document.getElementById('cidade').value = (response.dados.cidade);
            document.getElementById('uf').value = (response.dados.uf);
            document.getElementById('telefone').value = (response.dados.telefone);
            document.getElementById('celular').value = (response.dados.celular);
            document.getElementById('email').value = (response.dados.email);
            document.getElementById('sexo').value = (response.dados.sexo);
        }).catch((error) => {
            console.log(error);
        })
    }

    function salvar() {

            const dadosFormulario = document.getElementById('formulario');
            const dadosPessoa =  new FormData(dadosFormulario);
            dadosPessoa.set('acao', 'gravar');
            fetch('pessoacontroller.php', {
                method:'post',
                body: dadosPessoa
            }).then((response) => {
                return response.json();
            }).then((response) => {
                if (response.sucesso) {
                    alert('Dados salvo com sucesso');
                    location.href = 'listagemPessoa.php';
                }
            }).catch((error) => {
                console.log(error)
            })
    }

    function atualizar() {
            const dadosFormulario = document.getElementById('formulario');
            const dadosPessoa = new FormData(dadosFormulario);
            dadosPessoa.set('acao', 'atualizar');
            dadosPessoa.set('id', paramId);
            fetch('pessoacontroller.php', {
                method: 'post',
                body: dadosPessoa
            }).then((response) => {
                return response;
            }).then((response) => {
                console.log(response);
                alert('Dados atualizados com sucesso');
                location.href = 'listagemPessoa.php';
            }).catch((error) => {
                console.log(error);
            })
    }

    function voltar() {
        location.href = 'listagemPessoa.php';
    }

    function limpa_formulário_cep() {
        //Limpa valores do formulário de cep.
        document.getElementById('rua').value=("");
        document.getElementById('bairro').value=("");
        document.getElementById('cidade').value=("");
        document.getElementById('uf').value=("");
        document.getElementById('endereco').value=("");
    }

    function limparCampos() {
        document.getElementById('nome').value=("");
        document.getElementById('nascimento').value=("");
        document.getElementById('pai').value=("");
        document.getElementById('mae').value=("");
        document.getElementById('bairro').value=("");
        document.getElementById('rua').value=("");
        document.getElementById('cep').value=("");
        document.getElementById('cidade').value=("");
        document.getElementById('uf').value=("");
        document.getElementById('telefone').value=("");
        document.getElementById('celular').value=("");
        document.getElementById('email').value=("");
        document.getElementById('sexo').value=("");
    }

    function meu_callback(conteudo) {
        if (!("erro" in conteudo)) {
            //Atualiza os campos com os valores.
            document.getElementById('rua').value=(conteudo.logradouro);
            document.getElementById('bairro').value=(conteudo.bairro);
            document.getElementById('cidade').value=(conteudo.localidade);
            document.getElementById('uf').value=(conteudo.uf);
        } //end if.
        else {
            //CEP não Encontrado.
            limpa_formulário_cep();
            alert("CEP não encontrado.");
        }
    }

    function pesquisacep(valor) {

        //Nova variável "cep" somente com dígitos.
        var cep = valor.replace(/\D/g, '');

        //Verifica se campo cep possui valor informado.
        if (cep != "") {

            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;

            //Valida o formato do CEP.
            if(validacep.test(cep)) {

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

            } //end if.
            else {
                //cep é inválido.
                limpa_formulário_cep();
                alert("Formato de CEP inválido.");
            }
        } //end if.
        else {
            //cep sem valor, limpa formulário.
            limpa_formulário_cep();
        }
    };

</script>
</body>
</html>
