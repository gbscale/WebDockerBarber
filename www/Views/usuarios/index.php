<div class="container pt-4 pb-5 bg-light">

    <h2 class="border-bottom border-2 border-primary">
        <?= ucfirst($data['pagina']) ?>
    </h2>

    <form action="<?= base_url('usuarios/' . $data['method']); ?>" method="post">

        <?php if ($data['method'] == 'save') : ?>

            <div class="mb-3">
                <label for="nome_barbearia" class="form-label">
                    Nome da Barbearia
                </label>

                <input
                    type="text"
                    class="form-control"
                    name="nome_barbearia"
                    id="nome_barbearia"
                    required>
            </div>

        <?php endif; ?>

        <div class="mb-3">
            <label for="nome" class="form-label">
                Nome
            </label>

            <input
                type="text"
                class="form-control"
                name="nome"
                id="nome"
                value="<?= $data['usuarios']->nome ?? ''; ?>"
                required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">
                E-mail
            </label>

            <input
                type="email"
                class="form-control"
                name="email"
                id="email"
                value="<?= $data['usuarios']->email ?? ''; ?>"
                required>
        </div>

        <div class="mb-3">
            <label for="telefone" class="form-label">
                Telefone
            </label>

            <input
                type="text"
                class="form-control"
                name="telefone"
                id="telefone"
                value="<?= $data['usuarios']->telefone ?? ''; ?>"
                required>
        </div>

        <?php if ($data['method'] == 'save') : ?>

            <div class="mb-3">
                <label for="senha" class="form-label">
                    Senha
                </label>

                <input
                    type="password"
                    class="form-control"
                    name="senha"
                    id="senha"
                    required>
            </div>

        <?php endif; ?>

        <input
            type="hidden"
            name="id"
            value="<?= $data['usuarios']->id ?? ''; ?>">

        <div class="mb-3">
            <button type="submit" class="btn btn-success">
                Salvar
            </button>
        </div>

    </form>

</div>