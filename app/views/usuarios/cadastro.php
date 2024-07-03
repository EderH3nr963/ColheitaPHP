<main class="d-flex justify-content-center align-items-center">
    <section
        class="d-flex justify-content-center align-items-center form-cadastro w-50 h-75 shadow-lg p-3 mb-5 bg-body-tertiary rounded">
        <form  method="post" style="width:90%">
            <h1>Cadastro</h1>
            <div class="row mb-3">
                <div class="col">
                    <label for="" class="form-label">Email</label>
                    <input type="text" name="email" placeholder="Insera seu Email" class="form-control" maxlength="50">
                </div>
                <div class="col">
                    <label for="" class="form-label">Nome</label>
                    <input type="text" name="nome" placeholder="Insera seu Nome" class="form-control" maxlength="25">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label for="" class="form-label">Senha</label>
                    <input type="password" name="senha1" placeholder="Insira sua senha" class="form-control" maxlength="25">
                </div>
                <div class="col">
                    <label for="" class="form-label">Confirme a Senha</label>
                    <input type="password" name="senha2" placeholder="Insira sua senha novamente" class="form-control" maxlength="25">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Cadastre-se</button>
        </form>
    </section>
</main>