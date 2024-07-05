<?php
class PlantacaoHelper {
    public function weather($city) {
        $apiKey = $_ENV["API_KEY_WEATHER"]; // Sua chave de API
        $encodedCity = urlencode($city); // Codifica o nome da cidade para a URL
        $apiUrl = "http://api.openweathermap.org/data/2.5/weather?q={$encodedCity}&appid={$apiKey}&units=metric&lang=pt_br";

        // Faz a solicitação para a API
        $response = file_get_contents($apiUrl);

            // Decodifica a resposta JSON
        $weatherData = json_decode($response, true);

        return $weatherData;
    }

    public function getEstado() {
        $estado = file_get_contents(APP_PATH."\\helpers\\estados.json");
        $estado = json_decode($estado);

        return $estado;
    }

    public function checkEstado($uf) {
        $estado = $this->getEstado();

        foreach($estado as $uf1 => $info) {
            if ($uf1 == $uf) {
                return true;
            }
        }
    }

    public function validarData($data) {
        $formato = 'Y-m-d';
        $dataObj = DateTime::createFromFormat($formato, $data);
        return $dataObj && $dataObj->format($formato) === $data;
    }
}
