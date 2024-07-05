<?php

session_start();

$msg = "";

if (isset($_SESSION["usuarioNome"])) {
    header("Location: painel.php");
}

if (isset($_GET["msg"]) && $_GET["msg"] == (1 || 2)) {
    switch ($_GET["msg"]) {
        case 1:
            $msg = "<div class='alert alert-warning'>Necessário realizar o login.</div>";
            break;
        case 2:
            $msg = "<div class='alert alert-info'>Logout feito com sucesso!</div>";
            break;
    }
}

require_once("./Model/Usuario.php");
require_once("./Controller/UsuarioController.php");

$usuario = new Usuario();
$usuarioController = new UsuarioController();



//Cadastro Usuário
if (
    isset($_POST["txtEmailRegistro"]) && (isset($_POST["txtNomeRegistro"]) && isset($_POST["txtSenhaRegistro"])) &&
    (is_string($_POST["txtEmailRegistro"]) && (is_string($_POST["txtNomeRegistro"]) && (is_string($_POST["txtSenhaRegistro"]))))
) {




    $usuario->setNome($_POST["txtNomeRegistro"]);
    $usuario->setEmail($_POST["txtEmailRegistro"]);
    $usuario->setSenha(md5($_POST["txtSenhaRegistro"]));
    $usuario->setData(date("Y-m-d H:i:s"));

    $resultado = $usuarioController->Cadastrar($usuario);

    switch ($resultado) {
        case 1:
            $msg = "<div class='alert alert-success'>Usuário cadastrado com sucesso!</div>";
            break;
        case -1:
            $msg = "<div class='alert alert-warning'>Uusáro já cadastrado.</div>";
            break;

        case -2:
            $msg = "<div class='alert alert-warning'>Dados inválidos.</div>";
            break;
        case -10:
            $msg = "<div class='alert alert-danger'>Houve um error na hora do cadastro, tente novamente.</div>";
            break;
    }
}

////Login Usuário

if ((isset($_POST["txtEmailLogin"]) && isset($_POST["txtSenhaLogin"]) && ($_POST["txtEmailLogin"] != null && $_POST["txtSenhaLogin"] != null))) {
    $usuario = $usuarioController->Autenticar($_POST["txtEmailLogin"], $_POST["txtSenhaLogin"]);
    if ($usuario) {
        $_SESSION["usuarioNome"] = $usuario->getNome();
        $_SESSION["email"] = $usuario->getEmail();
        $_SESSION["data"] = $usuario->getData();
        header("Location: painel.php");
    } else {
        $msg = "<div class='alert alert-warning'>Usuário ou senha inválido.</div>";
    }
}

?>
<!DOCTYPE html>
<html Lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <!--LOGIN
        https://bootsnipp.com/snippets/featured/login-amp-signup-forms-in-panel
        -->
    <div class="container">
        <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="panel-title">Entrar</div>
                </div>

                <div style="padding-top:30px" class="panel-body">

                    <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>

                    <form id="frmEntrar" class="form-horizontal" role="form" method="post">

                        <div style="margin-bottom: 25px" class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input id="login-username" type="text" class="form-control" name="txtEmailLogin" value="" placeholder="E-mail">
                        </div>

                        <div style="margin-bottom: 25px" class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                            <input id="login-password" type="password" class="form-control" name="txtSenhaLogin" placeholder="password">
                        </div>

                        <div style="margin-top:10px" class="form-group">
                            <!-- Button -->
                            <div class="col-sm-12 controls">
                                <input type="submit" name="btnEntrar" value="Entrar" class="btn btn-success" />
                                <a href="#" onClick="$('#loginbox').hide();
                                            $('#signupbox').show()" class="btn btn-info">
                                    Registrar-se
                                </a>
                            </div>
                        </div>

                        <br>
                        <div>
                            <?= $msg; ?>
                        </div>

                    </form>
                </div>
            </div>
        </div>
        <div id="signupbox" style="display:none; margin-top:50px" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="panel-title">Registrar-se</div>
                </div>
                <div class="panel-body">
                    <form id="frmRegistrar" method="POST" class="form-horizontal" role="form">
                        <div class="form-group">
                            <label for="txtEmailRegistro" class="col-md-3 control-label">Email</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="txtEmailRegistro" placeholder="E-mail principal">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="txtNomeRegistro" class="col-md-3 control-label">Nome</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="txtNomeRegistro" placeholder="Nome completo">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="txtSenhaRegistro" class="col-md-3 control-label">Senha</label>
                            <div class="col-md-9">
                                <input type="password" class="form-control" name="txtSenhaRegistro" placeholder="*******">
                            </div>
                        </div>

                        <div class="form-group">
                            <!-- Button -->
                            <div class="col-md-offset-3 col-md-9">
                                <button id="btn-signup" type="submit" class="btn btn-info"><i class="icon-hand-right"></i> &nbsp Cadastrar</button>
                                <a id="signinlink" href="#" onclick="$('#signupbox').hide();
                                            $('#loginbox').show()" class="btn btn-default">Voltar</a>
                            </div>
                        </div>

                        <div style="border-top: 1px solid #999; padding-top:20px" class="form-group">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!---LOGIN-->
    <script src="js/jquery-3.2.1.min.js" type="text/javascript"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
</body>

</html>