<?php 
require_once dirname(__DIR__)."/app/config.php";
require_once APP_PATH."/models/UsuarioModel.php";
require_once APP_PATH."/models/PlantacaoModel.php";
require_once APP_PATH."/helpers/UsuarioHelper.php";
require_once APP_PATH."/helpers/PlantacaoHelper.php";

$usuarios = (new UsuarioModel())->readAll();

foreach($usuarios as $usuario) {
    $mensagemAlerta = "";
    $plantacoes = (new PlantacaoModel())->readAll($usuario['id']);
    if ((new PlantacaoModel())->getRow($usuario['id']) != 0 ){
        foreach ($plantacoes as $plantacao) {
            @$plantacaoClima = (new PlantacaoHelper())->weather($plantacao['cidade']);
            if ($plantacaoClima['cod'] == "200") {
                $temperature = $plantacaoClima['main']['temp'];
                $clima = $plantacaoClima['weather'][0]['description'];
                $color = "";

                if ($temperature <= 0 && strpos($weatherDescription, "frost") !== false) {
                    $alertaGeada = true;
                    $mensagemAlerta = $mensagemAlerta."<h1><b>Alerta de geada!</p></h1></br>" ;
                    $mensagemAlerta = $mensagemAlerta."<p>Temperatura: {$temperature}°C</p></br>";
                    $mensagemAlerta = $mensagemAlerta."<p>Descrição: {$clima}</p></br>";
                    $mensagemAlerta = $mensagemAlerta."<p>Estado: {$plantacao['estado']}</p></br>";
                    break;
                }
            }
            $dataAtual = new DateTime(date('Y-m-d'));
            $dataPlantio = new DateTime($plantacao['dataPlantio']);

            $diasPlantio = ($dataAtual->diff($dataPlantio))->days;

            if ($plantacao['diaIrrigacao'] != 0 && ($diasPlantio % $plantacao['diaIrrigacao']) == 0) {
                $mensagemAlerta = $mensagemAlerta."<h2><b>Dia de Irrigacao:</b></h2></br>";
                $mensagemAlerta = $mensagemAlerta."<p>Na safra de {$plantacao['tipoPlantio']}</p></br>";
                $mensagemAlerta = $mensagemAlerta."<p>No estado: {$plantacao['estado']}</p></br>";
            }
        }
    }
    if ($mensagemAlerta != ""){
        if ((new UsuarioHelper())->enviarEmail(
            $usuario['nome'],
            $usuario['email'],
            "Alert Eletro-Agro",
            $mensagemAlerta,
            ""
        )){
            echo "Sucesso!";
        }
    }
}