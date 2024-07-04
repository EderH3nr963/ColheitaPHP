<?php
class PlantacaoHelper {
    public function weather() {
        $apiKey = $_ENV["API_KEY_WEATHER"]; // Sua chave de API
        $city = "Sao Joaquim da Barra"; // Nome da cidade
        $encodedCity = urlencode($city); // Codifica o nome da cidade para a URL
        $apiUrl = "http://api.openweathermap.org/data/2.5/weather?q={$encodedCity}&appid={$apiKey}&units=metric&lang=pt_br";

        // Faz a solicitação para a API
        $response = file_get_contents($apiUrl);

        // Verifica se a solicitação foi bem-sucedida
        if ($response !== FALSE) {
            // Decodifica a resposta JSON
            $weatherData = json_decode($response, true);

            if ($weatherData['cod'] == 200) {
                return $weatherData;
            }
        } else {
            echo "Não foi possível obter os dados do clima.";
        }
    }
}
