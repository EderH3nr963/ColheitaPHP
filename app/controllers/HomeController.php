<?php
require APP_PATH."/models/PlantacaoModel.php";
require APP_PATH."/helpers/PlantacaoHelper.php";
class HomeController{
    public function index() {
        if (!isset($_SESSION['usuario'])) {
            header('Location: /usuario/login', True, 301);
            exit;
        }
        $plantacao = new PlantacaoModel();

        if ($plantacao->getRow($_SESSION['usuario']['id']) == 0) {
            $msg = "Nenhuma plantação cadastrada";
        } else {
            $plantacoes = $plantacao->readAll($_SESSION['usuario']['id']);
        }

        require_once APP_PATH."\\views\home\home.php";
    }
};