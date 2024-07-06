<main class="d-flex justify-content-center align-items-center">
    <section
        class="d-flex justify-content-center align-items-center form-cadastro w-50 h-75 shadow-lg p-3 mb-5 bg-body-tertiary rounded">
        <form method="post" style="width:90%">
            <h1>Criar Plantação</h1>
            <div class="row mb-3 mt-3">
                <div class="col">
                    <label for="" class="form-label">Tipo Plantio</label>
                    <input type="" name="tipoPlantio" placeholder="Ex: milho" class="form-control">
                </div>
                <div class="col">
                    <label for="" class="form-label">Data Plantio</label>
                    <input type="date" name="dataPlantio" class="form-control">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label for="" class="form-label">UF</label>
                    <select name="estado" id="" class="form-control w-25">
                        <?php foreach ($estado as $uf => $info) :?>
                            <option value='<?= $uf ?>'><?= $uf ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col w-25">
                    <label for="" class="form-label">Dias Irrigação</label>
                    <input type="text" class="form-control" name="diaIrrigacao" placeholder="Ex: 2">
                </div>
            </div>
            <?php if (isset($erro_msg)): ?>
                <div style="color:red"><?= isset($erro_msg) ? $erro_msg : "" ?></div>
            <?php endif; ?>
            <button type="submit" class="btn btn-primary">Criar</button>
        </form>
    </section>
</main>
