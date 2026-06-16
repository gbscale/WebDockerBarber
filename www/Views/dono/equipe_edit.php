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

    <h1 class="mb-4 text-white">
        Editar Colaborador
    </h1>

    <form method="POST" action="<?= base_url('dono/equipe/update?id=' . $membro->id) ?>">

        <div class="card">
            <div class="card-body">

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="text-white mb-2">Nome</label>
                        <input type="text" name="nome" value="<?= htmlspecialchars($membro->nome) ?>" class="form-control" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="text-white mb-2">Email</label>
                        <input type="email" name="email" value="<?= htmlspecialchars($membro->email) ?>" class="form-control" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="text-white mb-2">Telefone</label>
                        <input type="text" name="telefone" value="<?= htmlspecialchars($membro->telefone) ?>" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="text-white mb-2">Senha <small class="text-muted">(Deixe em branco para manter a atual)</small></label>
                        <input type="password" name="senha" class="form-control" placeholder="Nova senha se desejar alterar">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="text-white mb-2">Cargo</label>
                        <select name="cargo" class="form-select" required>
                            <option value="barbeiro" <?= $membro->cargo == 'barbeiro' ? 'selected' : '' ?>>Barbeiro</option>
                            <option value="recepcionista" <?= $membro->cargo == 'recepcionista' ? 'selected' : '' ?>>Recepcionista</option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="text-white mb-2">Atende Clientes?</label>
                        <select name="atende_clientes" class="form-select" required>
                            <option value="1" <?= $membro->atende_clientes == 1 ? 'selected' : '' ?>>Sim</option>
                            <option value="0" <?= $membro->atende_clientes == 0 ? 'selected' : '' ?>>Não</option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="text-white mb-2">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="1" <?= $membro->status == 1 ? 'selected' : '' ?>>Ativo</option>
                            <option value="0" <?= $membro->status == 0 ? 'selected' : '' ?>>Inativo</option>
                        </select>
                    </div>
                </div>

            </div>
        </div>

        <button class="btn btn-primary mt-3">
            Atualizar Colaborador
        </button>

        <a href="<?= base_url('dono/equipe') ?>" class="btn btn-secondary mt-3 ms-2">
            Cancelar
        </a>

    </form>

</div>