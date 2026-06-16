<div class="min-vh-100 d-flex align-items-center justify-content-center py-5">

    <div class="container">

        <div class="row justify-content-center">

            <div class="col-lg-6 col-md-8">

                <div class="card border-0 shadow-lg">

                    <div class="card-body p-5">

                        <div class="text-center mb-5">

                            <i class="bi bi-scissors fs-1 text-warning"></i>

                            <h2 class="text-white mt-3 mb-2">
                                <?= ucfirst($data['pagina']) ?>
                            </h2>

                            <p class="text-secondary mb-0">
                                Crie sua conta e comece a gerenciar sua barbearia.
                            </p>

                        </div>

                        <form action="<?= base_url('usuarios/' . $data['method']); ?>" method="POST">

                            <?php if ($data['method'] == 'save') : ?>

                                <div class="mb-3">

                                    <label for="nome_barbearia" class="form-label text-white">
                                        <i class="bi bi-shop me-2"></i>
                                        Nome da Barbearia
                                    </label>

                                    <input
                                        type="text"
                                        class="form-control"
                                        name="nome_barbearia"
                                        id="nome_barbearia"
                                        placeholder="Ex: Easy Barber"
                                        required>

                                </div>

                            <?php endif; ?>

                            <div class="mb-3">

                                <label for="nome" class="form-label text-white">
                                    <i class="bi bi-person me-2"></i>
                                    Nome Completo
                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    name="nome"
                                    id="nome"
                                    value="<?= $data['usuarios']->nome ?? ''; ?>"
                                    placeholder="Digite seu nome"
                                    required>

                            </div>

                            <div class="mb-3">

                                <label for="email" class="form-label text-white">
                                    <i class="bi bi-envelope me-2"></i>
                                    E-mail
                                </label>

                                <input
                                    type="email"
                                    class="form-control"
                                    name="email"
                                    id="email"
                                    value="<?= $data['usuarios']->email ?? ''; ?>"
                                    placeholder="Digite seu e-mail"
                                    required>

                            </div>

                            <div class="mb-3">

                                <label for="telefone" class="form-label text-white">
                                    <i class="bi bi-telephone me-2"></i>
                                    Telefone
                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    name="telefone"
                                    id="telefone"
                                    value="<?= $data['usuarios']->telefone ?? ''; ?>"
                                    placeholder="(00) 00000-0000"
                                    required>

                            </div>

                            <?php if ($data['method'] == 'save') : ?>

                                <div class="mb-4">

                                    <label for="senha" class="form-label text-white">
                                        <i class="bi bi-lock me-2"></i>
                                        Senha
                                    </label>

                                    <input
                                        type="password"
                                        class="form-control"
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

                                <button type="submit" class="btn btn-primary btn-lg">

                                    <i class="bi bi-check-circle me-2"></i>

                                    <?= $data['method'] == 'save' ? 'Criar Conta' : 'Salvar Alterações' ?>

                                </button>

                            </div>

                        </form>

                        <div class="text-center mt-4">

                            <small class="text-secondary">

                                Já possui uma conta?

                                <a href="<?= base_url('login') ?>" class="text-warning text-decoration-none">
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