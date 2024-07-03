<?php
session_start();
require_once 'C:\Users\ederh\OneDrive\Área de Trabalho\ColheitaPHP\app\config.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= TITLE ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="\css\general\general.css">
    <link rel="stylesheet" href="\css\general\cadastro.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary" width="10px" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Navbar</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Pricing</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" aria-disabled="true">Disabled</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <?php
        // Inclua o autoload (se estiver usando Composer)
        // require BASE_PATH . '/vendor/autoload.php';

        // Função de autoload para carregar classes dos controladores, modelos, etc.
        spl_autoload_register(function ($class) {
            $path = APP_PATH . '/' . str_replace('\\', '/', $class) . '.php';
            if (file_exists($path)) {
                require $path;
            }
        });

        // Parsear a URL para determinar o controlador e a ação
        $url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
        $url = str_replace('/public', '', $url);
        $url = rtrim($url, '/');
        $url = filter_var($url, FILTER_SANITIZE_URL);
        $url = explode('/', $url);

        // Definir controlador, ação e parâmetros padrão
        $controllerName = isset($url[1]) && !empty($url[1]) ? ucfirst($url[1]) . 'Controller' : 'HomeController';
        $actionName = isset($url[2]) && !empty($url[2]) ? $url[2] : 'index';
        $params = array_slice($url, 3);

        // Verificar se o controlador existe
        $controllerFile = APP_PATH . '/controllers/' . $controllerName . '.php';
        if (file_exists($controllerFile)) {
            require $controllerFile;
            $controller = new $controllerName;

            // Verificar se o método (ação) existe no controlador
            if (method_exists($controller, $actionName)) {
                call_user_func_array([$controller, $actionName], $params);
            } else {
                // Ação não encontrada
                header("HTTP/1.0 404 Not Found");
                echo "Ação não encontrada.";
                exit();
            }
        } else {
            // Controlador não encontrado
            header("HTTP/1.0 404 Not Found");
            echo "Controlador não encontrado.";
            exit();
        }
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
