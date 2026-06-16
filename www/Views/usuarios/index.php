<div class="container min-vh-100 d-flex align-items-center justify-content-center py-5">

    <div class="card bg-dark border-secondary shadow-lg login-card" style="max-width: 450px; width: 100%;">

        <div class="card-body p-5">

            <div class="text-center mb-4">

                <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3 login-logo" style="width: 60px; height: 60px;">
                    <i class="bi bi-scissors fs-3"></i>
                </div>

                <h2 class="text-white fw-bold mb-1">
                    <?= ucfirst($data['pagina']) ?>
                </h2>

                <p class="text-secondary small mb-0">
                    <?php if ($data['method'] == 'save') : ?>
                        Crie sua conta e gerencie sua barbearia.
                    <?php else : ?>
                        Atualize suas informações.
                    <?php endif; ?>
                </p>

            </div>

            <form action="<?= base_url('usuarios/' . $data['method']); ?>" method="POST">

                <?php if ($data['method'] == 'save') : ?>

                    <div class="mb-3">
                        <label for="nome_barbearia" class="form-label text-white small fw-bold">
                            <i class="bi bi-shop me-2"></i>Nome da Barbearia
                        </label>
                        <input
                            type="text"
                            class="form-control bg-black text-white border-secondary py-2"
                            name="nome_barbearia"
                            id="nome_barbearia"
                            placeholder="Ex.: Barbearia Elite"
                            required>
                    </div>

                <?php endif; ?>

                <div class="mb-3">
                    <label for="nome" class="form-label text-white small fw-bold">
                        <i class="bi bi-person me-2"></i>Nome Completo
                    </label>
                    <input
                        type="text"
                        class="form-control bg-black text-white border-secondary py-2"
                        name="nome"
                        id="nome"
                        placeholder="Digite seu nome"
                        value="<?= $data['usuarios']->nome ?? ''; ?>"
                        required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label text-white small fw-bold">
                        <i class="bi bi-envelope me-2"></i>E-mail
                    </label>
                    <input
                        type="email"
                        class="form-control bg-black text-white border-secondary py-2"
                        name="email"
                        id="email"
                        placeholder="Digite seu e-mail"
                        value="<?= $data['usuarios']->email ?? ''; ?>"
                        required>
                </div>

                <div class="mb-3">
                    <label for="telefone" class="form-label text-white small fw-bold">
                        <i class="bi bi-telephone me-2"></i>Telefone
                    </label>
                    <input
                        type="text"
                        class="form-control bg-black text-white border-secondary py-2"
                        name="telefone"
                        id="telefone"
                        placeholder="(00) 00000-0000"
                        value="<?= $data['usuarios']->telefone ?? ''; ?>"
                        required>
                </div>

                <?php if ($data['method'] == 'save') : ?>

                    <div class="mb-4">
                        <label for="senha" class="form-label text-white small fw-bold">
                            <i class="bi bi-lock me-2"></i>Senha
                        </label>
                        <input
                            type="password"
                            class="form-control bg-black text-white border-secondary py-2"
                            name="senha"
                            id="senha"
                            placeholder="Crie uma senha segura"
                            required>
                    </div>

                <?php endif; ?>

                <input
                    type="hidden"
                    name="id"
                    value="<?= $data['usuarios']->id ?? ''; ?>">

                <button type="submit" class="btn btn-danger btn-login w-100 fw-bold py-2 shadow">
                    <i class="bi bi-check-circle me-2"></i>
                    <?php if ($data['method'] == 'save') : ?>
                        Criar Conta
                    <?php else : ?>
                        Salvar Alterações
                    <?php endif; ?>
                </button>

            </form>

            <?php if ($data['method'] == 'save') : ?>

                <div class="text-center mt-4">
                    <span class="text-secondary small">Já possui uma conta?</span>
                    <a href="<?= base_url('login') ?>" class="text-danger fw-bold text-decoration-none ms-1 small">
                        Entrar
                    </a>
                </div>

            <?php endif; ?>

        </div>

    </div>

</div>