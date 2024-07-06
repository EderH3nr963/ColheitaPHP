    <main>
        <?php $cont = 0?>
        <?php foreach($plantacoes as $values){
            $cont += 1;
        } ?>
        <section class="dashboard">
            <h1>Bem-vindo ao AgriManage</h1>
            <div class="overview">
                <div class="card">
                    <h2>Total de Plantações</h2>
                    <p><?= $cont ?></p>
                </div>
                <div class="card">
                    <h2>Área Cultivada</h2>
                    <p>350 hectares</p>
                </div>
            </div>
        </section>
        <section>
            <h2>Irrigações para hoje</h2>
            <table class="table" style="margin-left:10px">
                <thead>
                    <tr>
                        <th scope="col">Tipo Plantio</th>
                        <th scope="col">Clima</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Alerta</th>
                    </tr>
                </thead>
                <?php if (!(isset($msg))): ?>
                    <?php foreach($plantacoes as $values): ?>
                        <?php 
                            // Tipo do Clima
                            $mensagemAlerta = "Não há previsão de geada.";
                            @$plantacaoClima = (new PlantacaoHelper())->weather($values['cidade']);
                            if ($plantacaoClima['cod'] == "200") {
                                $temperature = $plantacaoClima['main']['temp'];
                                $clima = $plantacaoClima['weather'][0]['description'];
                                $color = "";

                                if ($temperature <= 0 && strpos($weatherDescription, "frost") !== false) {
                                    $alertaGeada = true;
                                    $mensagemAlerta = "Alerta de geada! Temperatura: {$temperature}°C, Descrição: {$clima}";
                                    break;
                                }
                            } else {
                                $clima = "Não foi possivel importar o clima";
                                $color = "red";
                            }

                            // Diferença de dias
                            $dataAtual = new DateTime(date('Y-m-d'));
                            $dataPlantio = new DateTime($values['dataPlantio']);

                            $diasPlantio = $dataAtual->diff($dataPlantio);
                            $diaIrrigacao = $diasPlantio->days % ((int)$values['diaIrrigacao'])
                        ?> 
                        <?php if ($diaIrrigacao == 0): ?>
                            <tbody>
                                <tr>
                                    <td><?= $values['tipoPlantio'] ?></td>
                                    <td style="color:<?= $color ?>"><?= $clima ?></td>
                                    <td><?= $values['estado'] ?></td>
                                    <td style="color:<?= $alertaGeada ? "red" : "" ?>"><?= $mensagemAlerta ?></td>
                                </tr>
                            </tbody>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </table>
        </section>
    </main>