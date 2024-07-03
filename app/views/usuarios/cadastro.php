<?php
if (isset($_SESSION['formulario'])) {
    $nome = $_SESSION['formulario']['nome'];
    $email = $_SESSION['formulario']['email'];
    $senha1 = $_SESSION['formulario']['senha1'];
    $senha2 = $_SESSION['formulario']['senha2'];
}
?>
<main class="d-flex justify-content-center align-items-center">
    <section
        class="d-flex justify-content-center align-items-center form-cadastro w-50 h-75 shadow-lg p-3 mb-5 bg-body-tertiary rounded">
        <form method="post" style="width:90%">
            <h1>Cadastro</h1>
            <div class="row mb-3">
                <div class="col">
                    <label for="" class="form-label">Email</label>
                    <input type="text" name="email" value="<?= isset($_SESSION['formulario']) ? $email : '' ?>"
                        placeholder="Insera seu Email"
                        class="form-control <?= isset($_SESSION['msg_erro_1']) || isset($_SESSION['msg_erro_2']) || isset($_SESSION['msg_erro_5']) ? 'is-invalid' : "" ?>"
                        maxlength="50">
                        <?php if (isset($_SESSION['msg_erro_2'])): ?>
                            <div class="invalid-feedback"><?= $_SESSION['msg_erro_2'] ?></div>
                        <?php endif; ?>
                        <?php if (isset($_SESSION['msg_erro_5'])): ?>
                            <div class="invalid-feedback"><?= $_SESSION['msg_erro_5'] ?></div>
                        <?php endif; ?>
                </div>
                <div class="col">
                    <label for="" class="form-label">Nome</label>
                    <input type="text" name="nome" value="<?= isset($_SESSION['formulario']) ? $nome : '' ?>"
                        placeholder="Insera seu Nome"
                        class="form-control <?= isset($_SESSION['msg_erro_1']) ? 'is-invalid' : "" ?>"
                        maxlength="25">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label for="" class="form-label">Senha</label>
                    <input type="password" name="senha1" value="<?= isset($_SESSION['formulario']) ? $senha1 : '' ?>"
                        placeholder="Insira sua senha"
                        class="form-control <?= isset($_SESSION['msg_erro_1']) || isset($_SESSION['msg_erro_3']) || isset($_SESSION['msg_erro_4']) ? 'is-invalid' : "" ?>"
                        maxlength="25">
                    <?php if (isset($_SESSION['msg_erro_1'])): ?>
                        <div class="invalid-feedback"><?= $_SESSION['msg_erro_1'] ?></div>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['msg_erro_3'])): ?>
                        <div class="invalid-feedback"><?= $_SESSION['msg_erro_3'] ?></div>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['msg_erro_4'])): ?>
                        <div class="invalid-feedback"><?= $_SESSION['msg_erro_4'] ?></div>
                    <?php endif; ?>
                </div>
                <div class="col">
                    <label for="" class="form-label">Confirme a Senha</label>
                    <input type="password" name="senha2" value="<?= isset($_SESSION['formulario']) ? $senha2 : '' ?>"
                        placeholder="Insira sua senha novamente"
                        class="form-control <?= isset($_SESSION['msg_erro_1']) || isset($_SESSION['msg_erro_3']) ? 'is-invalid' : "" ?>"
                        maxlength="25">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Cadastre-se</button>
        </form>
    </section>
</main>
<?php
unset($_SESSION['formulario']);
unset($_SESSION['msg_erro_1']);
unset($_SESSION['msg_erro_2']);
unset($_SESSION['msg_erro_3']);
unset($_SESSION['msg_erro_4']);
unset($_SESSION['msg_erro_5']);
?>