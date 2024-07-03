<?php
@session_start();
require BASE_PATH.'\app\models\UsuarioModel.php';
require APP_PATH.'\helpers\PasswordHelper.php';

class UsuarioController {
    public function cadastro() {
        if ($_SERVER['REQUEST_METHOD'] == "GET") {
            require_once BASE_PATH . '\app\views\usuarios\cadastro.php';
        } else {
            
            $usuario = new UsuarioModel();

            $formulario = $_POST;
            $email = trim(addslashes($_POST['email']));
            $nome = trim(addslashes($_POST['nome']));
            $senha1 = trim(addslashes($_POST['senha1']));
            $senha2 = trim(addslashes($_POST['senha2']));

            if (in_array('', $formulario)) {
                echo "Campos vazios no array";
            } else {
                if (!(filter_var($email, FILTER_VALIDATE_EMAIL))) {
                    echo "Email Invalido";
                } else if ($senha1 != $senha2 && strlen($senha1) < 8 || strlen($senha1) > 25) {
                    echo "As senha não coincidem";
                } else if ((new PasswordHelper)->isWeakPassword($senha1)) {
                    echo " senha muito fraca";
                } else if ($usuario->getRow($email) != 0 ){
                    echo "email já existente";
                } else {

                    $senha1 = password_hash($senha1, PASSWORD_DEFAULT);

                    $usuario->create($nome, $email, $senha1) or die("falha ao cadastrar");
                    $fetchUsuario = $usuario->read($email);
                    $_SESSION['usuario'] = array(
                        'id' => $fetchUsuario['id'], 
                        'nome' => $fetchUsuario['nome'], 
                        'email' => $fetchUsuario['email']
                    );
                }
            }

        }
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == "GET") {
            require_once BASE_PATH . '\app\views\usuarios\login.php';
        } else {
            $email = trim(addslashes($_POST['email']));
            $senha1 = trim(addslashes($_POST['senha1']));

            if (in_array('', $_POST)) {
                echo "Campos vazios no array";
            } else {
                $usuario = new UsuarioModel();
                $fetchUsuario = $usuario->read($email);

                if ($usuario->getRow($email) < 1){
                    echo "Usuário não existe";
                } else {
                    foreach($usuario as $value) {
                        if ($email == $value['email'] && password_verify($senha1, $value['senha'])) {
                            $_SESSION['usuario'] = array($value['email'], $value['nome']);
                        } else {
                            echo "Falha ao fazer login";
                        }
                    }
                }
            }
        }
    }
}

