<?php

require_once("./Model/Usuario.php");

class UsuarioDAO
{

    private $debug = true;
    private $dir = "Arquivos";

    public function Cadastrar(Usuario $usuario)
    {
        $fileName = $usuario->getEmail() . ".txt";

        if (!$this->CheckFileExists($fileName)) {

            $dirCompleto = $this->dir . "/" . $fileName;

            $FileConnection = fopen($dirCompleto, "w");

            $str = "{$usuario->getNome()};{$usuario->getEmail()};{$usuario->getSenha()};{$usuario->getData()}";

            if (fwrite($FileConnection, $str)) {
                fclose($FileConnection);
                return 1;
            } else {
                return -10;
            }
        } else {
            return -1;
        }

        try {
        } catch (Throwable $ex) {
            if ($this->debug) {
                echo $ex->getMessage();
            }
        }
    }

    private function CheckFileExists(string $fileName)
    {
        $dirCompleto = $this->dir . "/" . $fileName;

        if (file_exists($dirCompleto)) {
            return  true;
        } else {
            return false;
        }
    }

    public function RetonarUsuario(string $email)
    {
        if ($this->CheckFileExists($email)) {

            $dirCompleto = $this->dir . "/" . $email;

            $fileConnection = fopen($dirCompleto, "r");

            $ConteudoFile = fread($fileConnection, filesize($dirCompleto));

            $vetorDados = explode(';', $ConteudoFile);

            $usuario = new Usuario();
            $usuario->setNome($vetorDados[0]);
            $usuario->setEmail($vetorDados[1]);
            $usuario->setSenha($vetorDados[2]);
            $usuario->setData($vetorDados[3]);

            fclose($fileConnection);

            return $usuario;
        } else {
            return null;
        }
    }

    public function Autenticar(string $email, string $senha){

        $fileName = $email.".txt";

        if($this->CheckFileExists($fileName)){
            $usuario = $this->RetonarUsuario($fileName);

            if(md5($senha) == $usuario->getSenha()){
                return $usuario;
            }else{
                return null;
            }
        }else{
            return null;
        }
    }
}
