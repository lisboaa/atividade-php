<?php

require_once __DIR__ . '/../services/PessoaService.php';
class PessoaController
{
    public function buscarPessoa() {
        try {
            $dadosPessoa = (new PessoaService())->listar();
            return json_encode(array("sucesso" => true, "message" => "Dados retornado com sucesso", "dados" => $dadosPessoa));
        }catch (Exception $exception) {
            return $exception->getMessage();
        }
    }

    public function salvar()
    {
        $formData = json_decode(file_get_contents("php://input"));

        try{
            (new PessoaService())->salvar($formData);
            return json_encode(array("sucesso" => true, "dados" => "Dados salvos com sucesso"));
        } catch(InvalidArgumentException $ex) {
            return json_encode(array("sucesso" => false, "type" => 'INCORRECT', "dados" => $ex->getMessage()));
        } catch(Exception $ex) {
            return json_encode(array("sucesso" => false, "dados" => $ex->getMessage()));
        }

    }

    public function buscarId()
    {
        $formData = json_decode(file_get_contents("php://input"));
        try{
            $dadosPessoa = (new PessoaService())->buscarId($formData);
            return json_encode(array("sucesso" => true, "message" => "Consulta retornada com sucesso", "dados" => $dadosPessoa));
        } catch(Exception $ex) {
            return json_encode(array("sucesso" => false, "dados" => $ex->getMessage()));
        }

    }

    public function atualizar() {
        $formData = json_decode(file_get_contents("php://input"));
        try {
            $dadosPessoa = (new PessoaService())->atualizar($formData);
            return json_encode(array("sucesso" => true, "message" => "Dados atualizados com sucesso", "dados" => $dadosPessoa));
        }catch (PDOException $exception) {
            return json_encode(array("sucesso" => false, "dados" => $exception->getMessage()));
        }
    }
}

switch ($_GET['acao']) {
    case 'salvar':
        echo (new PessoaController)->salvar();
        break;
    case 'atualizar':
        echo (new PessoaController)->atualizar();
        break;
    case 'excluir':
        echo (new PessoaController)->excluir();
        break;
    case 'buscarId':
        echo (new PessoaController)->buscarId();
        break;
    case 'listar':
        echo (new PessoaController)->buscarPessoa();
        break;
    default:
        echo 'não existe a açao';
        break;
}