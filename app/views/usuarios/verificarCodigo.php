<main class="d-flex justify-content-center align-items-center">
    <section style="flex-direction:column"
        class="d-flex justify-content-center align-items-right form-cadastro w-25 h-75 shadow-lg p-3 mb-5 bg-body-tertiary rounded">
        <h1>Verificar Email</h1>
        <form action="" method="POST">
            <div class="col mb-5 mt-5">
                <label for="" class="form-label">Código de verificação</label>
                <input type="text" name="cod" class="form-control" placeholder="Código de 6 digitos">
            </div>
            <?php if (isset($msg)) : ?>
                <div style="color:red"><?= $msg ?></div>
            <?php endif; ?>
            <button type="submit" class="btn btn-primary">Verificar</button>
        </form>
    </section>
</main>