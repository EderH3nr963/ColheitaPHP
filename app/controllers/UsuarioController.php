<?php
@session_start();
require BASE_PATH.'\app\models\UsuarioModel.php';
require APP_PATH.'\helpers\UsuarioHelper.php';

class UsuarioController {
    public function cadastro() {
        if (isset($_SESSION['usuario'])) {
            header("Location: http://localhost/", True, 301);
            exit;
        }else if ($_SERVER['REQUEST_METHOD'] == "GET") {
            require_once BASE_PATH . '\app\views\usuarios\cadastro.php';
        } else {
            
            $usuario = new UsuarioModel();

            $formulario = $_POST;
            $email = trim(addslashes($_POST['email']));
            $nome = trim(addslashes($_POST['nome']));
            $senha1 = trim(addslashes($_POST['senha1']));
            $senha2 = trim(addslashes($_POST['senha2']));

            // Validação dos Campos
            if (in_array('', $formulario)) {
                $_SESSION['msg_erro_1'] = "Os campos não podem ser nullos";
                $_SESSION['formulario'] = $formulario;
                require_once BASE_PATH . '\app\views\usuarios\cadastro.php';
            } else {
                //valida Email
                if (!(filter_var($email, FILTER_VALIDATE_EMAIL))) {
                    $_SESSION['msg_erro_2'] = "Email Inválido";
                    $_SESSION['formulario'] = $formulario;
                    require_once BASE_PATH . '\app\views\usuarios\cadastro.php';
                }
                // valida Senha
                else if ($senha1 != $senha2 && strlen($senha1) < 8 || strlen($senha1) > 25) {
                    $_SESSION['msg_erro_3'] = "As senhas não coincidem";
                    $_SESSION['formulario'] = $formulario;
                    require_once BASE_PATH . '\app\views\usuarios\cadastro.php';
                }
                //Verifica se a senha é fraca
                else if ((new UsuarioHelper)->isWeakPassword($senha1)) {
                    $_SESSION['msg_erro_4'] = "A senha precisa ter letras maiusculas, números e ao menos um caracter especial";
                    $_SESSION['formulario'] = $formulario;
                    require_once BASE_PATH . '\app\views\usuarios\cadastro.php';
                } 
                // Valida se o usuario ja existe
                else if ($usuario->getRow($email) != 0 ){
                    $_SESSION['msg_erro_5'] = "Usuario ja existente";
                    $_SESSION['formulario'] = $formulario;
                    require_once BASE_PATH . '\app\views\usuarios\cadastro.php';
                } else {
                    $senha1 = password_hash($senha1, PASSWORD_DEFAULT);// Cria a hash da senha

                    $usuario->create($nome, $email, $senha1) or die("falha ao cadastrar");
                    $fetchUsuario = $usuario->read($email);
                    $_SESSION['usuario'] = array(
                        'id' => $fetchUsuario['id'], 
                        'nome' => $fetchUsuario['nome'], 
                        'email' => $fetchUsuario['email'],
                        'authEmail' => $fetchUsuario['emailAuthenticate']
                    );

                    header("Location: http://localhost/usuario/verificarEmail", True, 301);
                    exit;
                }
            }

        }
    }

    public function login() {
        if (isset($_SESSION['usuario'])) {
            header("Location: http://localhost/", True, 301);
            exit;
        }else if ($_SERVER['REQUEST_METHOD'] == "GET") {
            require_once BASE_PATH . '\app\views\usuarios\login.php';
        } else {
            $email = trim(addslashes($_POST['email']));
            $senha1 = trim(addslashes($_POST['senha1']));

            $usuario = new UsuarioModel();
            $fetchUsuario = $usuario->read($email);

            if ($usuario->getRow($email) < 1){
                $_SESSION['msg_erro_5'] = "Email ou Senha Inválidos";
                $_SESSION['email'] = $email;
                require_once BASE_PATH . '\app\views\usuarios\login.php';
            } else {
                if ($email == $fetchUsuario['email'] && password_verify($senha1, $fetchUsuario['senha'])) {
                    $_SESSION['usuario'] = array(
                        'id' => $fetchUsuario['id'], 
                        'nome' => $fetchUsuario['nome'], 
                        'email' => $fetchUsuario['email'],
                        'authEmail' => $fetchUsuario['emailAuthenticate']
                    );
                    header("Location: http://localhost/", True, 301);
                    exit;
                } else {
                    $_SESSION['msg_erro_5'] = "Email ou Senha Inválidos";
                    $_SESSION['email'] = $email;
                    require_once BASE_PATH . '\app\views\usuarios\login.php';
                }
            }
        }
    }

    public function atualizarSenha() {
        if (!(isset($_SESSION['usuario']))) {
            header("Location: /usuario/login", True, 301);
            exit;
        } else if ($_SERVER['REQUEST_METHOD'] == "GET") {
            require_once BASE_PATH . "\app/views\usuarios\atualizarSenha.php";
        } else {
            $usuario = new UsuarioModel();

            //pegar os campos do formulário
            $senha1 = trim(addslashes($_POST['senha1']));
            $senha2 = trim(addslashes($_POST['senha2']));
            $senha3 = trim(addslashes($_POST['senha3']));

            // Chama o usuario do banco de dados
            $fetchUsuario = $usuario->read($_SESSION['usuario']['email']);

            if ($senha2 != $senha3) {
                $_SESSION['msg_erro_6'] = "Senhas não coicidem";
                require_once BASE_PATH . '\app\views\usuarios\atualizarSenha.php';
            } else if (!(password_verify($senha1, $fetchUsuario['senha']))) {
                $_SESSION['msg_erro_6'] = "Senha Inválida";
                require_once BASE_PATH . '\app\views\usuarios\atualizarSenha.php';
            } else if ((new UsuarioHelper)->isWeakPassword($senha2)) {
                $_SESSION['msg_erro_6'] = "Senha muito fraca";
                require_once BASE_PATH . '\app\views\usuarios\atualizarSenha.php';
            } else {
                $hash = password_hash($senha2, PASSWORD_DEFAULT);

                $usuario->updateSenha($_SESSION['usuario']['email'], $hash);

                header("Location: /", True, 301);
                exit;
            }
        }
    }
    public function verificarEmail() {
        if (isset($_SESSION['usuario']) && $_SESSION['usuario']['authEmail'] == "0") {
            if ($_SERVER['REQUEST_METHOD'] == "GET") {
                require_once APP_PATH."\\views\\usuarios\\verificarEmail.php";
            } else {
                $codVerif = rand(100000, 999999);
                
                $nomeDest = $_SESSION['usuario']['nome'];
                $emailDest = $_SESSION['usuario']['email'];
                $subject = "Código de verificação de email";
                $body = "Seu código de verificação é <b>$codVerif</b>";
                $altBody = "";
                
                if ((new UsuarioHelper)->enviarEmail($nomeDest, $emailDest, $subject, $body, $altBody)) {
                        $_SESSION['codVerif'] = $codVerif;
                        $_SESSION['codVerifTime'] = time();
                        
                        header("Location: /usuario/verificarCodigo");
                        exit;
                } else {
                        echo "<p>Erro ao enviar o código</p>";
                }
            }
        } else {
            header("Location: /", true, 301);
            exit;
        }
    }

    public function verificarCodigo() {
        if (isset($_SESSION['codVerif']) && $_SESSION['usuario']['authEmail'] == "0") {
            $expireTime = 600;
            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                $codVerif = $_POST['cod'];
                $storageCod = $_SESSION['codVerif'];
                $storageTime = $_SESSION['codVerifTime'];

                unset($_SESSION['codVerif']);
                unset($_SESSION['codVerifTime']);

                if (time() - $storageTime < $expireTime ) {
                    if ($codVerif == $storageCod) {
                        $msgTitle = "Veiricação feita com sucesso";
                        $msg = "Verificação foi feita com sucesso";

                        if ((new UsuarioModel)->updateAuthenticateEmail(1, $_SESSION['usuario']['email'])) {
                            $_SESSION['usuario']['authEmail'] = 1;
                            require_once APP_PATH."\\views\\usuarios\\alert.php";
                            return 0;
                        } else {
                            $msg = "Código inválido";
                        }
                    } else {
                        $msg = "Código inválido";
                    }
                } else {
                    $msg = "Codigo de verificação expirou";
                }

            }

            require APP_PATH."\\views\\usuarios\\verificarCodigo.php";
        } else {
            header("Location: /");
            exit;
        }
    }

    public function excluirConta() {
        if (!(isset($_SESSION['usuario']))) {
            header("Location: /usuario/login", True, 301);
            exit;
        } else if ($_SERVER['REQUEST_METHOD'] == "GET") {
            require_once APP_PATH."/views/usuarios/excluirConta.php";
        } else {
            (new UsuarioModel())->delete($_SESSION['usuario']['email']) or die("Falha ao excluir o usuario");
            unset($_SESSION['usuario']);

            header("Location: /", True, 301);
            exit;
        }
    }

    public function logout() {
        unset($_SESSION['usuario']);

        header("Location: /", True, 301);
        exit;
    }
}

