<main>
    <section style="margin-left:10%;margin-right:10%;margin-top:10px">
        <h1>Minhas Plantações</h1>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Tipo Plantio</th>
                    <th scope="col">Clima</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Dias de Plantio</th>
                    <th scope="col">Data de Plantio</th>
                    <th scope="col">Excluir</th>
                    <th scope="col">Atualizar</th>
                </tr>
            </thead>
            <?php if (!(isset($msg))): ?>
                <?php foreach($plantacoes as $values): ?>
                    <?php 
                        // Tipo do Clima
                        @$plantacaoClima = (new PlantacaoHelper())->weather($values['cidade']);
                        if ($plantacaoClima['cod'] == "200") {
                            $clima = $plantacaoClima['weather'][0]['description'];
                            $color = "";
                        } else {
                            $clima = "Não foi possivel importar o clima";
                            $color = "red";
                        }

                        // Diferença de dias
                        $dataAtual = new DateTime(date('Y-m-d'));
                        $dataPlantio = new DateTime($values['dataPlantio']);

                        $diasPlantio = $dataAtual->diff($dataPlantio);
                    ?> 
                    <tbody>
                        <tr>
                            <td><?= $values['tipoPlantio'] ?></td>
                            <td style="color:<?= $color ?>"><?= $clima ?></td>
                            <td><?= $values['estado'] ?></td>
                            <td><?= $diasPlantio->days ?></td>
                            <td><?= $values['dataPlantio'] ?></td>
                            <td><a class="btn btn-danger" href="/plantacao/excluir/<?= $values['idPlantacao'] ?>"></a></td>
                            <td></td>
                        </tr>
                    </tbody>
                <?php endforeach; ?>
            <?php endif; ?>
        </table>
        <?= isset($msg) ? "<p>$msg</p>" : "" ?>
        <a href="/plantacao/criarPlantacao" class="float btn btn-primary">
            Adicionar Plantação
        </a>
    </section>
</main>