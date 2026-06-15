<?php
if (
    !isset($_SESSION['usuario_logado']) ||
    $_SESSION['usuario_logado']->cargo != 'dono'
) {
    redirectPage(base_url('login'));
    exit;
}
?>

<div class="main-content">

    <div class="mb-4">

        <h1 class="text-white mb-1">
            Configurações
        </h1>

        <p class="text-secondary">
            Gerencie sua conta e sua barbearia.
        </p>

    </div>

    <form method="POST" action="<?= base_url('dono/configuracoes/save') ?>">

        <div class="row g-4">

            <!-- Dados da Barbearia -->

            <div class="col-lg-6">

                <div class="card h-100">

                    <div class="card-body">

                        <h5 class="text-white mb-4">
                            Dados da Barbearia
                        </h5>

                        <div class="mb-3">

                            <label class="form-label text-white">
                                Nome da Barbearia
                            </label>

                            <input
                                type="text"
                                name="nome_barbearia"
                                class="form-control"
                                value="<?= $barbearia->nome ?? '' ?>"
                                required>

                        </div>

                        <div class="mb-3">

                            <label class="form-label text-white">
                                Telefone
                            </label>

                            <input
                                type="text"
                                name="telefone_barbearia"
                                class="form-control"
                                value="<?= $barbearia->telefone ?? '' ?>">

                        </div>

                        <div class="mb-3">

                            <label class="form-label text-white">
                                E-mail da Barbearia
                            </label>

                            <input
                                type="email"
                                name="email_barbearia"
                                class="form-control"
                                value="<?= $barbearia->email ?? '' ?>">

                        </div>

                    </div>

                </div>

            </div>

            <!-- Minha Conta -->

            <div class="col-lg-6">

                <div class="card h-100">

                    <div class="card-body">

                        <h5 class="text-white mb-4">
                            Minha Conta
                        </h5>

                        <div class="mb-3">

                            <label class="form-label text-white">
                                Nome
                            </label>

                            <input
                                type="text"
                                name="nome"
                                class="form-control"
                                value="<?= $usuario->nome ?? '' ?>"
                                required>

                        </div>

                        <div class="mb-3">

                            <label class="form-label text-white">
                                E-mail
                            </label>

                            <input
                                type="email"
                                name="email"
                                class="form-control"
                                value="<?= $usuario->email ?? '' ?>"
                                required>

                        </div>

                        <div class="mb-3">

                            <label class="form-label text-white">
                                Telefone
                            </label>

                            <input
                                type="text"
                                name="telefone"
                                class="form-control"
                                value="<?= $usuario->telefone ?? '' ?>">

                        </div>

                        <div class="mb-3">

                            <label class="form-label text-white">
                                Nova Senha
                            </label>

                            <input
                                type="password"
                                name="senha"
                                class="form-control"
                                placeholder="Deixe em branco para manter a senha atual">

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="mt-4">

            <button type="submit" class="btn btn-primary">

                <i class="bi bi-check-lg"></i>
                Salvar Alterações

            </button>

        </div>

    </form>

</div>