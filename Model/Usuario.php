<?php

class Usuario{
    private $nome;
    private $email;
    private $senha;
    private $data;


    //Set para estar fazendo a atribuição

    public function setNome($nome){
        $this->nome = $nome;
    }

    public function setEmail($email){
        $this->email = $email;
    }

    public function setSenha($senha){
        $this->senha = $senha;
    }

    public function setData($data){
        $this->data = $data;
    }


    //Get para obter

    public function getNome(){
        return $this->nome;
    }

    public function getEmail(){
        return $this->email;
    }

    public function getSenha(){
        return $this->senha;
    }

    public function getData(){
        return $this->data;
    }

}


?>