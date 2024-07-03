<main class="d-flex justify-content-center align-items-center">
    <section
        style="height: 80%;width: 30%"
        class="d-flex justify-content-center align-items-center form-cadastro shadow-lg p-3 mb-5 bg-body-tertiary rounded">
        <form method="post" style="width:90%">
            <h1>Atualizar Senha</h1>
            <div class="row mb-1">
                <label for="" class="form-label">Senha Antiga</label>
                <input type="password" name="senha1" id="" class="form-control">
            </div>
            <div class="row mb-1">
                <label for="" class="form-label">Nova Senha</label>
                <input type="password" name="senha2" id="" class="form-control">
            </div>
            <div class="row mb-2">
                <label for="" class="form-label">Confirmar Senha</label>
                <input type="password" name="senha3" id="" class="form-control">
            </div>
            <?php if (isset($_SESSION['msg_erro_6'])): ?>
                <span style="color:red;font-size:14px"><?= $_SESSION['msg_erro_6'] ?></span><br>
            <?php endif; ?>
            <button type="submit" class="btn btn-primary">Atualizar</button>
        </form>
    </section>
</main>
<?php
    unset($_SESSION['msg_erro_6']);
?>