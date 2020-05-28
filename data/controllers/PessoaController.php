<?php

require_once __DIR__ . '/../services/PessoaService.php';
$formData = json_decode(file_get_contents("php://input"));
class PessoaController
{
    public function buscarPessoa() {
        try {
            $pessoa = (new PessoaService())->buscarId();
        }catch (Exception $exception) {
            return $exception->getMessage();
        }
        return json_encode(array('sucesso' => true, 'dados' => $pessoa));
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
        echo (new PessoaController)->listar();
        break;
    default:
        echo 'não existe a açao';
        break;
}