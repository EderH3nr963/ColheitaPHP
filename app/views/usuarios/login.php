<main class="d-flex justify-content-center align-items-center">
    <section
        class="d-flex justify-content-center align-items-center form-cadastro w-25 h-75 shadow-lg p-3 mb-5 bg-body-tertiary rounded">
        <form method="post" style="width:90%">
            <h1>Login</h1>
            <div class="row mb-3">
                <label for="" class="form-label">Email</label>
                <input type="text" name="email" value="<?= isset($_SESSION['email']) ? $email : '' ?>"
                    placeholder="Insera seu Email" class="form-control" maxlength="50">
            </div>
            <div class="row mb-5">
                <label for="" class="form-label">Senha</label>
                <input type="password" name="senha1" placeholder="Insira sua senha" class="form-control" maxlength="25">
                <?php if (isset($_SESSION['msg_erro_5'])): ?>
                    <span style="color:red;font-size:14px; margin:0px"><?= $_SESSION['msg_erro_5'] ?></span><br>
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-primary">Entre</button>
        </form>
    </section>
</main>
<?php
unset($_SESSION['email']);
unset($_SESSION['msg_erro_5']);
?>