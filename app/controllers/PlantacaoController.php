<?php 
require APP_PATH."/helpers/PlantacaoHelper.php";
require APP_PATH."/models/PlantacaoModel.php";
class PlantacaoController {
    public function minhasPlantacoes() {
        if (!isset($_SESSION['usuario'])) {
            header('Location: /', True, 301);
            exit;
        }
        // Chama o model da Plantação
        $plantacao = new PlantacaoModel();

        if ($plantacao->getRow($_SESSION['usuario']['id']) == 0) {
            $msg = "Nenhuma plantação cadastrada";
        } else {
            $plantacoes = $plantacao->readAll($_SESSION['usuario']['id']);
        }

        //Carregar o WeatherApi
        $city = "sdasdad";
        

        require_once APP_PATH."\\views\plantacao\minhasPlantacoes.php";
    }

    public function criarPlantacao() {
        if (!isset($_SESSION['usuario'])) {
            header('Location: /', True, 301);
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $estado = (new PlantacaoHelper())->getEstado();
            
            require_once APP_PATH."\\views\plantacao\criarPlantacao.php";
            return 0;
        } else {
            // Recebe os dados do formulario
            $tipoPlantio = $_POST['tipoPlantio'];
            $dataPlantio = $_POST['dataPlantio'];
            $uf = $_POST['estado'];
            $diaIrrigacao = $_POST['diaIrrigacao'];

            // Pega os estados válidos
            $estado = (new PlantacaoHelper())->getEstado();

            // Chama o model da Plantação
            $plantacao = new PlantacaoModel();

            
            
            // Valida o formulário
            if (in_array('', $_POST)) {
                $erro_msg = "Não pode haver campos nulos";
                
                require_once APP_PATH."\\views\plantacao\criarPlantacao.php";
                return 0;
            }
            
            // Valida a UF
            if (!((new PlantacaoHelper())->checkEstado($uf))) {
                $erro_msg = "Estado Inválido";
                
                require_once APP_PATH."\\views\plantacao\criarPlantacao.php";
                return 0;
            }

            // Pega o nome da cidade
            foreach ($estado as $uf1 => $info) {
                if ($uf1 == $uf){
                    $estado = $info->estado;
                    $cidade = $info->capital;
                }
            }
            
            // Valida a Data
            if (!((new PlantacaoHelper())->validarData($dataPlantio))) {
                $erro_msg = "Data Inválida";

                require_once APP_PATH."\\views\plantacao\criarPlantacao.php";
                return 0;
            }

            // Cria o Plantação no banco de dados
            if ($plantacao->create($tipoPlantio, $cidade, $dataPlantio, $_SESSION['usuario']['id'], $estado, $diaIrrigacao)) {
                header("Location: /plantacao/minhasPlantacoes", true, 301);
                exit;
            } else {
                $erro_msg = "Falha ao cadastrar a Safra";

                header("Location: /plantacao/minhasPlantacoes", true, 301);
                exit;
            }
        }
    }

    public function excluir($idPlantio) {
        if (!isset($_SESSION['usuario'])) {
            header('Location: /', True, 301);
            exit;
        }
        
        $plantacao = new PlantacaoModel();

        if ($plantacao->delete($idPlantio, $_SESSION['usuario']['id'])) {
            header('Location: /plantacao/minhasPlantacoes');
            exit;
        } else { 
            header('Location: /plantacao/minhasPlantacoes');
            exit;
        }
    }
}   