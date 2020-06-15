<?php


class Pessoa
{
    private $nome;
    private $sexo;
    private $pai;
    private $mae;
    private $endereco;
    private $bairro;
    private $cep;
    private $cidade;
    private $uf;
    private $telefone;
    private $celular;
    private $email;
    private $nascimento;

    function getNome() {
        return $this->nome;
    }

    function setNome($nome) {
        return $this->nome = $nome;
    }

    function getSexo() {
        return $this->sexo;
    }

    function setSexo($sexo) {
        return $this->sexo = $sexo;
    }

    function getPai() {
        return $this->pai;
    }

    function setPai($pai) {
        return $this->pai = $pai;
    }

    function getMae() {
        return $this->mae;
    }

    function setMae($mae) {
        return $this->mae = $mae;
    }

    function getEndereco() {
        return $this->endereco;
    }

    function setEndereco($endereco) {
        return $this->mae = $endereco;
    }

    function getBairro() {
        return $this->bairro;
    }

    function setBairro($bairro) {
        return $this->bairro = $bairro;
    }

    function setCep($cep) {
        return $this->cep = $cep;
    }

    function getCep() {
        return $this->cep;
    }

    function getCidade() {
        return $this->cidade;
    }

    function setCidade($cidade) {
        return $this->cidade = $cidade;
    }

    function getUf() {
        return $this->uf;
    }

    function setUf($uf) {
        return $this->uf = $uf;
    }

    function getTelefone() {
        return $this->telefone;
    }

    function setTelefone($telefone) {
        return $this->telefone = $telefone;
    }

    function getCelular() {
        return $this->celular;
    }

    function setCelular($celular) {
        return $this->celular = $celular;
    }

    function getEmail() {
        return $this->email;
    }

    function setEmail($email) {
        return $this->email = $email;
    }

    function getNascimento() {
        return $this->nascimento;
    }

    function setNascimento($nascimento) {
        return $this->nascimento = $nascimento;
    }
}