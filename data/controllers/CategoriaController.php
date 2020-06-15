<?php
require_once __DIR__ . '/../services/CategoriaService.php';

class CategoriaController
{
    public function salvar() {
        $formData = json_decode(file_get_contents("php://input"));
        try {
            $dadosCategoria = (new CategoriaService())->salvar($formData);
            return json_encode(array('sucesso' => true, 'dados' => $dadosCategoria, 'message' =>  'Dados salvos com sucesso'));
        } catch (Exception $exception) {
            return json_encode(array('sucesso' => false, 'dados' => $exception->getMessage()));
        }
    }

}

switch ($_GET['acao']) {
    case 'salvar':
        echo (new CategoriaController)->salvar();
        break;
}