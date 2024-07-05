<?php

require_once("./DAL/UsuarioDAO.php");

class UsuarioController
{
    private $usuarioDAO;

    public function __construct()
    {
        $this->usuarioDAO = new UsuarioDAO();
    }

    public function Cadastrar(Usuario $usuario)
    {
        if (strlen($usuario->getNome()) > 4 && strlen($usuario->getSenha()) > 7 && strpos($usuario->getEmail(), "@") > 0) {
            return $this->usuarioDAO->Cadastrar($usuario);
        }else{
            return -2;
        }
    }

    public function RetonarUsuario(string $email){
        if(strpos($email, "@") > 0){
            return $this->usuarioDAO->RetonarUsuario($email);
        }else{
            return null;
        }
    }

    public function Autenticar(string $email, string $senha){
        if(strpos($email, "@") > 0){
            return $this->usuarioDAO->Autenticar($email, $senha);
        }else{
            return null;
        }
    }
}

?>