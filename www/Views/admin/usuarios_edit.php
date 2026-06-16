<div class="main-content">

    <div class="mb-4">
        <h1 class="text-white mb-1"><i class="bi bi-person-gear text-warning me-2"></i>Editar Usuário</h1>
        <p class="text-secondary mb-0">Modifique os dados de acesso ou altere a senha da conta.</p>
    </div>

    <div class="card bg-dark border-secondary" style="max-width: 600px;">
        <div class="card-body p-4">
            
            <form action="<?= base_url('admin/usuarios/update') ?>" method="POST">
                <input type="hidden" name="id" value="<?= $usuario->id ?>">

                <div class="mb-3">
                    <label class="text-secondary small fw-bold mb-2">Nome do Usuário</label>
                    <input type="text" name="nome" class="form-control bg-black text-white border-secondary" value="<?= htmlspecialchars($usuario->nome) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="text-secondary small fw-bold mb-2">E-mail (Login)</label>
                    <input type="email" name="email" class="form-control bg-black text-white border-secondary" value="<?= htmlspecialchars($usuario->email) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="text-secondary small fw-bold mb-2">Nova Senha (Deixe em branco para manter a atual)</label>
                    <input type="password" name="senha" class="form-control bg-black text-white border-secondary" placeholder="Digite a nova senha apenas se quiser alterar">
                </div>

                <div class="mb-4">
                    <label class="text-secondary small fw-bold mb-2">Status do Acesso</label>
                    <select name="status" class="form-select bg-black text-white border-secondary">
                        <option value="1" <?= $usuario->status == 1 ? 'selected' : '' ?>>Ativo (Acesso Liberado)</option>
                        <option value="0" <?= $usuario->status == 0 ? 'selected' : '' ?>>Bloqueado (Acesso Suspenso)</option>
                    </select>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-warning fw-bold px-4">Salvar Alterações</button>
                    <a href="<?= base_url('admin/usuarios') ?>" class="btn btn-outline-secondary">Cancelar</a>
                </div>
            </form>

        </div>
    </div>

</div>