<div class="main-content">
    <div class="mb-4">
        <h1 class="text-white">Meu Perfil</h1>
        <p class="text-secondary">Gerencie suas credenciais de acesso e informações pessoais.</p>
    </div>

    <?php if (isset($_SESSION['msg'])): ?>
        <div class="alert alert-<?= $_SESSION['msg']['color'] ?> mb-3"><?= $_SESSION['msg']['texto'] ?></div>
        <?php unset($_SESSION['msg']); ?>
    <?php endif; ?>

    <div class="card bg-dark text-white border-secondary">
        <div class="card-body">
            <form method="POST" action="<?= base_url('barbeiro/configuracoes/save') ?>">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label text-white-50">Seu Nome Completo</label>
                        <input type="text" name="nome" class="form-control bg-black text-white border-secondary" value="<?= htmlspecialchars($usuario->nome) ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-white-50">E-mail de Login</label>
                        <input type="email" name="email" class="form-control bg-black text-white border-secondary" value="<?= htmlspecialchars($usuario->email) ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-white-50">Telefone de Contato</label>
                        <input type="text" name="telefone" class="form-control bg-black text-white border-secondary" value="<?= htmlspecialchars($usuario->telefone) ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-white text-warning">Alterar Senha de Acesso</label>
                        <input type="password" name="senha" class="form-control bg-black text-white border-warning" placeholder="Deixe em branco para manter a senha atual">
                    </div>
                </div>

                <div class="mt-4 border-top border-secondary pt-3">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-save me-2"></i>Atualizar Perfil</button>
                </div>
            </form>
        </div>
    </div>
</div>