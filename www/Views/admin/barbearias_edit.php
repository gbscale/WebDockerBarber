<div class="main-content">

    <div class="mb-4">
        <h1 class="text-white mb-1"><i class="bi bi-pencil-square text-warning me-2"></i>Editar Licença</h1>
        <p class="text-secondary mb-0">Altere o plano ou os dados de cadastro da barbearia selecionada.</p>
    </div>

    <div class="card bg-dark border-secondary" style="max-width: 600px;">
        <div class="card-body p-4">
            
            <form action="<?= base_url('admin/barbearias/update') ?>" method="POST">
                <input type="hidden" name="id" value="<?= $barbearia->id ?>">

                <div class="mb-3">
                    <label class="text-secondary small fw-bold mb-2">Nome da Barbearia</label>
                    <input type="text" name="nome_barbearia" class="form-control bg-black text-white border-secondary" value="<?= htmlspecialchars($barbearia->nome) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="text-secondary small fw-bold mb-2">Responsável Legal</label>
                    <input type="text" name="nome_responsavel" class="form-control bg-black text-white border-secondary" value="<?= htmlspecialchars($barbearia->responsavel) ?>" required>
                </div>

                <div class="mb-4">
                    <label class="text-secondary small fw-bold mb-2">Plano Contratado</label>
                    <select name="plano" class="form-select bg-black text-white border-secondary">
                        <option value="light" <?= $barbearia->plano == 'light' ? 'selected' : '' ?>>Easy Light (R$ 59,90)</option>
                        <option value="pro" <?= $barbearia->plano == 'pro' ? 'selected' : '' ?>>Easy Pro (R$ 119,90)</option>
                        <option value="ultimate" <?= $barbearia->plano == 'ultimate' ? 'selected' : '' ?>>Easy Ultimate IA (R$ 199,90)</option>
                    </select>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-warning fw-bold px-4">Salvar Alterações</button>
                    <a href="<?= base_url('admin') ?>" class="btn btn-outline-secondary">Cancelar</a>
                </div>
            </form>

        </div>
    </div>

</div>