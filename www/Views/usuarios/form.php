<div class="min-vh-100 d-flex align-items-center justify-content-center py-5">

    <div class="container">

        <div class="row justify-content-center">

            <div class="col-lg-6 col-md-8">

                <div class="card bg-dark border-secondary shadow-lg login-card">

                    <div class="card-body p-5">

                        <div class="text-center mb-5">

                            <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3 login-logo" style="width: 60px; height: 60px;">
                                <i class="bi bi-scissors fs-3"></i>
                            </div>

                            <h2 class="text-white mt-3 mb-2 fw-bold">
                                <?= ucfirst($data['pagina']) ?>
                            </h2>

                            <p class="text-secondary small mb-0">
                                Crie sua conta e comece a gerenciar sua barbearia.
                            </p>

                        </div>

                        <form action="<?= base_url('usuarios/' . $data['method']); ?>" method="POST">

                            <?php if ($data['method'] == 'save') : ?>

                                <div class="mb-3">

                                    <label for="nome_barbearia" class="form-label text-white small fw-bold">
                                        <i class="bi bi-shop me-2"></i>
                                        Nome da Barbearia
                                    </label>

                                    <input
                                        type="text"
                                        class="form-control bg-black text-white border-secondary py-2"
                                        name="nome_barbearia"
                                        id="nome_barbearia"
                                        placeholder="Ex: Easy Barber"
                                        required>

                                </div>

                            <?php endif; ?>

                            <div class="mb-3">

                                <label for="nome" class="form-label text-white small fw-bold">
                                    <i class="bi bi-person me-2"></i>
                                    Nome Completo
                                </label>

                                <input
                                    type="text"
                                    class="form-control bg-black text-white border-secondary py-2"
                                    name="nome"
                                    id="nome"
                                    value="<?= $data['usuarios']->nome ?? ''; ?>"
                                    placeholder="Digite seu nome"
                                    required>

                            </div>

                            <div class="mb-3">

                                <label for="email" class="form-label text-white small fw-bold">
                                    <i class="bi bi-envelope me-2"></i>
                                    E-mail
                                </label>

                                <input
                                    type="email"
                                    class="form-control bg-black text-white border-secondary py-2"
                                    name="email"
                                    id="email"
                                    value="<?= $data['usuarios']->email ?? ''; ?>"
                                    placeholder="Digite seu e-mail"
                                    required>

                            </div>

                            <div class="mb-3">

                                <label for="telefone" class="form-label text-white small fw-bold">
                                    <i class="bi bi-telephone me-2"></i>
                                    Telefone
                                </label>

                                <input
                                    type="text"
                                    class="form-control bg-black text-white border-secondary py-2"
                                    name="telefone"
                                    id="telefone"
                                    value="<?= $data['usuarios']->telefone ?? ''; ?>"
                                    placeholder="(00) 00000-0000"
                                    required>

                            </div>

                            <?php if ($data['method'] == 'save') : ?>

                                <div class="mb-4">

                                    <label for="senha" class="form-label text-white small fw-bold">
                                        <i class="bi bi-lock me-2"></i>
                                        Senha
                                    </label>

                                    <input
                                        type="password"
                                        class="form-control bg-black text-white border-secondary py-2"
                                        name="senha"
                                        id="senha"
                                        placeholder="Crie uma senha"
                                        required>

                                </div>

                            <?php endif; ?>

                            <input
                                type="hidden"
                                name="id"
                                value="<?= $data['usuarios']->id ?? ''; ?>">

                            <div class="d-grid">

                                <button type="submit" class="btn btn-danger btn-login btn-lg fw-bold shadow py-2">

                                    <i class="bi bi-check-circle me-2"></i>

                                    <?= $data['method'] == 'save' ? 'Criar Conta' : 'Salvar Alterações' ?>

                                </button>

                            </div>

                        </form>

                        <div class="text-center mt-4">

                            <small class="text-secondary">

                                Já possui uma conta?

                                <a href="<?= base_url('login') ?>" class="text-danger fw-bold text-decoration-none ms-1">
                                    Entrar
                                </a>

                            </small>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>