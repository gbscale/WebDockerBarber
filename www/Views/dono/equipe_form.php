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

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h1 class="text-white mb-1">
                Novo Barbeiro
            </h1>

            <p class="text-secondary mb-0">
                Cadastre um novo colaborador na equipe.
            </p>
        </div>

        <a
            href="<?= base_url('dono/equipe') ?>"
            class="btn btn-secondary">

            <i class="bi bi-arrow-left"></i>
            Voltar

        </a>

    </div>

    <form
        method="POST"
        action="<?= base_url('dono/equipe/save') ?>">

        <div class="card">

            <div class="card-body">

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Nome
                        </label>

                        <input
                            type="text"
                            name="nome"
                            class="form-control"
                            required>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Email
                        </label>

                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            required>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Telefone
                        </label>

                        <input
                            type="text"
                            name="telefone"
                            class="form-control"
                            required>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Senha
                        </label>

                        <input
                            type="password"
                            name="senha"
                            class="form-control"
                            required>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Cargo
                        </label>

                        <select
                            name="cargo"
                            class="form-select">

                            <option value="barbeiro">
                                Barbeiro
                            </option>

                            <option value="recepcionista">
                                Recepcionista
                            </option>

                        </select>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Atende Clientes?
                        </label>

                        <select
                            name="atende_clientes"
                            class="form-select">

                            <option value="1">
                                Sim
                            </option>

                            <option value="0">
                                Não
                            </option>

                        </select>

                    </div>

                </div>

            </div>

        </div>

        <div class="mt-4">

            <button
                type="submit"
                class="btn btn-primary">

                <i class="bi bi-check-circle"></i>
                Salvar Colaborador

            </button>

        </div>

    </form>

</div>