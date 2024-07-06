<main class="d-flex justify-content-center align-items-center">
    <section style="flex-direction:column"
        class="d-flex justify-content-center align-items-right form-cadastro w-50 h-75 shadow-lg p-3 mb-5 bg-body-tertiary rounded">
        <h1>Verificar Email</h1>
        <p>Iremos enviar um email com código de verificação<br>para o email <?= $_SESSION['usuario']['email'] ?></p>
        <form action="" method="POST">
            <a href="/" class="btn btn-outline-primary">Pular</a>
            <button type="submit" class="btn btn-primary">Verificar</button>
        </form>
    </section>
</main>