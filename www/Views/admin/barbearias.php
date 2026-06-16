<div class="main-content">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="text-white mb-1"><i class="bi bi-shop text-danger me-2"></i>Barbearias Cadastradas</h1>
            <p class="text-secondary mb-0">Controle total sobre as empresas parceiras e limites de uso.</p>
        </div>
        <a href="<?= base_url('admin/barbearias/new') ?>" class="btn btn-danger">
            <i class="bi bi-plus-circle me-2"></i>Nova Barbearia
        </a>
    </div>

    <div class="card bg-dark border-secondary">
        <div class="card-body p-4">
            
            <!-- BARRA DE BUSCA DINÂMICA (Sem mexer no Controller) -->
            <div class="d-flex justify-content-end mb-4">
                <div class="input-group" style="max-width: 400px;">
                    <span class="input-group-text bg-black border-secondary text-secondary"><i class="bi bi-search"></i></span>
                    <input type="text" id="input-busca-barbearia-lista" class="form-control bg-black text-white border-secondary" placeholder="Buscar por nome ou plano...">
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-dark table-hover align-middle mb-0" id="tabela-barbearias-lista">
                    <thead>
                        <tr class="text-secondary border-secondary">
                            <th>ID</th>
                            <th>Nome da Barbearia</th>
                            <th>Plano Atual</th>
                            <th>Status</th>
                            <th class="text-center" width="150">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($barbearias)): ?>
                            <?php foreach($barbearias as $b): ?>
                                <!-- Adicionado a classe 'linha-barbearia' para o JavaScript encontrar -->
                                <tr class="border-secondary linha-barbearia">
                                    <td class="text-secondary">#<?= $b->id ?></td>
                                    <td class="fw-bold text-white name-txt"><?= htmlspecialchars($b->nome) ?></td>
                                    <td>
                                        <!-- Atualizado para plano_nome (vindo do JOIN do banco) -->
                                        <?php if(!empty($b->plano_nome)): ?>
                                            <span class="badge bg-black border border-primary text-primary text-uppercase px-2 py-1 plano-txt">
                                                <?= htmlspecialchars($b->plano_nome) ?>
                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-black border border-secondary text-secondary text-uppercase px-2 py-1 plano-txt">
                                                Sem Plano Activo
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($b->status == 1): ?>
                                            <span class="badge bg-success-subtle text-success">Ativa</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger-subtle text-danger">Suspensa</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group gap-1">
                                            <a href="<?= base_url('admin/barbearias/view?id='.$b->id) ?>" class="btn btn-sm btn-outline-light border-secondary" title="Ver Detalhes"><i class="bi bi-eye"></i></a>
                                            <a href="<?= base_url('admin/barbearias/edit?id='.$b->id) ?>" class="btn btn-sm btn-outline-warning" title="Editar"><i class="bi bi-pencil"></i></a>
                                            <a href="<?= base_url('admin/barbearias/status?id='.$b->id) ?>" class="btn btn-sm <?= $b->status == 1 ? 'btn-outline-danger' : 'btn-success' ?>" title="Alterar Status" onclick="return confirm('Alterar status desta licença?')">
                                                <i class="bi <?= $b->status == 1 ? 'bi-slash-circle' : 'bi-check-lg' ?>"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center py-4 text-secondary">Nenhuma barbearia registrada no sistema.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<!-- SCRIPT DE FILTRO EM TEMPO REAL -->
<script>
document.getElementById('input-busca-barbearia-lista').addEventListener('keyup', function() {
    let filtro = this.value.toLowerCase();
    let linhas = document.querySelectorAll('#tabela-barbearias-lista .linha-barbearia');
    
    linhas.forEach(linha => {
        let nome = linha.querySelector('.name-txt').innerText.toLowerCase();
        let plano = linha.querySelector('.plano-txt').innerText.toLowerCase();
        
        if(nome.includes(filtro) || plano.includes(filtro)) {
            linha.style.display = '';
        } else {
            linha.style.display = 'none';
        }
    });
});
</script>