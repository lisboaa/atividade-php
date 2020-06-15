<?php

require_once __DIR__ . '/../../conexao.php';

class AnuncioService
{
    public function salvar($formData) {

        $imagePath = '../src/img/'. uniqid() .'.png';
        $contentImage = base64_decode(str_replace('data:image/png;base64,','',$formData->imagem ));
        file_put_contents($imagePath, $contentImage);

        $db = Banco::getConnection();
        $db->beginTransaction();
        $salvar = $db->prepare('INSERT INTO anuncios SET titulo = :titulo, descricao = :descricao,
                                        estado = :estado, valor = :valor, id_categoria = :id_categoria, imagem = :imagem');
        $salvar->bindValue(':titulo', $formData->titulo, PDO::PARAM_STR);
        $salvar->bindValue(':descricao', $formData->descricao, PDO::PARAM_STR);
        $salvar->bindValue(':estado', $formData->estado, PDO::PARAM_STR);
        $salvar->bindValue(':valor', $formData->valor);
        $salvar->bindValue(':id_categoria', $formData->id_categoria, PDO::PARAM_INT);
        $salvar->bindValue(':imagem', $imagePath, PDO::PARAM_STR);
        $salvar->execute();
        if (!$salvar) {
            $db->rollBack();
            die('Houve um erro na inserção dos dados');
        }
        $db->commit();
        return true;
    }

    function buscarCategorias() {
        $db = Banco::getConnection();
        $buscar = $db->prepare('SELECT * FROM categoria');
        $buscar->execute();
        $buscarDados = $buscar->fetchAll(PDO::FETCH_ASSOC);
        return $buscarDados;
    }

    function buscarAnuncios() {
        $db = Banco::getConnection();
        $buscarAnuncios = $db->prepare('SELECT * FROM anuncios');
        $buscarAnuncios->execute();
        $dadosAnuncio = $buscarAnuncios->fetchAll(PDO::FETCH_ASSOC);
        return $dadosAnuncio;
    }
}