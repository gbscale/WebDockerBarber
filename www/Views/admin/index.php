<div class="main-content">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="text-white mb-1 fw-bold">Painel Administrativo Master</h1>
            <p class="text-secondary mb-0">Monitoramento em tempo real de todas as instâncias e faturamentos da plataforma.</p>
        </div>
        <a href="<?= base_url('admin/barbearias/new') ?>" class="btn btn-danger px-4 py-2 fw-bold shadow">
            <i class="bi bi-plus-circle me-2"></i>Nova Barbearia
        </a>
    </div>

    <!-- CARDS DE MÉTRICAS -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card bg-dark border-secondary shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <small class="text-secondary text-uppercase fw-bold" style="font-size: 11px; letter-spacing: 0.5px;">Barbearias Ativas</small>
                        <i class="bi bi-shop text-danger fs-5"></i>
                    </div>
                    <h2 class="text-white mt-2 mb-0 fw-bold"><?= $totalBarbearias ?></h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-dark border-secondary shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <small class="text-secondary text-uppercase fw-bold" style="font-size: 11px; letter-spacing: 0.5px;">Usuários Totais</small>
                        <i class="bi bi-people text-info fs-5"></i>
                    </div>
                    <h2 class="text-white mt-2 mb-0 fw-bold"><?= $totalUsuarios ?></h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-dark border-secondary shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <small class="text-secondary text-uppercase fw-bold" style="font-size: 11px; letter-spacing: 0.5px;">Assinaturas Ativas</small>
                        <i class="bi bi-patch-check text-success fs-5"></i>
                    </div>
                    <h2 class="text-success mt-2 mb-0 fw-bold"><?= $planosAtivos ?></h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-dark border-secondary shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <small class="text-secondary text-uppercase fw-bold" style="font-size: 11px; letter-spacing: 0.5px;">Receita Mensal (MRR)</small>
                        <i class="bi bi-graph-up-arrow text-warning fs-5"></i>
                    </div>
                    <h2 class="text-warning mt-2 mb-0 fw-bold">R$ <?= number_format($receitaMensal, 2, ',', '.') ?></h2>
                </div>
            </div>
        </div>
    </div>

    <!-- LISTAGEM DE TENANTS -->
    <div class="card bg-dark border-secondary shadow-sm">
        <div class="card-body p-4">
            
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
                <div>
                    <h5 class="text-white mb-1">Empresas e Barbearias Contratantes</h5>
                    <p class="text-muted small mb-0">Controle de acessos, suspensões e auditoria de planos cadastrados.</p>
                </div>
                <div class="input-group" style="max-width:350px;">
                    <span class="input-group-text bg-black border-secondary text-secondary"><i class="bi bi-search"></i></span>
                    <input type="text" id="input-busca-barbearia" class="form-control bg-black text-white border-secondary" placeholder="Filtrar barbearia por nome...">
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-dark table-hover align-middle mb-0" id="tabela-barbearias">
                    <thead>
                        <tr class="text-secondary border-secondary" style="font-size: 13px;">
                            <th class="py-3">Nome da Barbearia</th>
                            <th class="py-3">Responsável Legal</th>
                            <th class="py-3">Plano Contratado</th>
                            <th class="py-3 text-center">Funcionários</th>
                            <th class="py-3">Status da Licença</th>
                            <th class="py-3 text-center" width="180">Ações de Controle</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if(!empty($barbearias)): ?>
                        <?php foreach($barbearias as $barbearia): ?>
                            <tr class="border-secondary linha-barbearia">
                                <td class="fw-bold text-white fs-6 py-3">
                                    <?= htmlspecialchars($barbearia->nome) ?>
                                </td>
                                <td class="text-white-50">
                                    <?= htmlspecialchars($barbearia->responsavel_nome ?? 'Não identificado') ?>
                                </td>
                                <td>
                                    <?php if(!empty($barbearia->plano_nome)): ?>
                                        <span class="badge bg-black border border-primary text-primary text-uppercase px-2.5 py-1.5" style="font-size: 11px;">
                                            <i class="bi bi-box-semibold me-1"></i><?= htmlspecialchars($barbearia->plano_nome) ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-black border border-secondary text-secondary text-uppercase px-2.5 py-1.5" style="font-size: 11px;">
                                            <i class="bi bi-x-circle me-1"></i>Nenhum Plano
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="fw-bold text-info text-center">
                                    <?= $barbearia->total_funcionarios ?>
                                </td>
                                <td>
                                    <?php if($barbearia->status == 1): ?>
                                        <span class="badge bg-success-subtle text-success px-2.5 py-1.5">
                                            <i class="bi bi-check-circle-fill me-1"></i>Ativa
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-danger-subtle text-danger px-2.5 py-1.5">
                                            <i class="bi bi-exclamation-octagon-fill me-1"></i>Suspensa
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group gap-1">
                                        <a href="<?= base_url('admin/barbearias/view?id='.$barbearia->id) ?>" class="btn btn-sm btn-outline-light border-secondary" title="Ver Informações">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="<?= base_url('admin/barbearias/edit?id='.$barbearia->id) ?>" class="btn btn-sm btn-outline-warning" title="Editar Licença">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="<?= base_url('admin/barbearias/status?id='.$barbearia->id) ?>" class="btn btn-sm <?= $barbearia->status == 1 ? 'btn-outline-danger' : 'btn-success' ?>" title="<?= $barbearia->status == 1 ? 'Bloquear Barbearia' : 'Reativar' ?>" onclick="return confirm('Tem certeza que deseja alterar o status desta licença?')">
                                            <i class="bi <?= $barbearia->status == 1 ? 'bi-slash-circle' : 'bi-check-lg' ?>"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-5 text-secondary">
                                <i class="bi bi-shield-exclamation fs-1 d-block mb-3 text-muted"></i>
                                <h5 class="text-white">Nenhum Tenant Localizado</h5>
                                <p class="text-muted small">Cadastre a primeira barbearia para começar a computar receita.</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<script>
document.getElementById('input-busca-barbearia').addEventListener('keyup', function() {
    let filtro = this.value.toLowerCase();
    let linhas = document.querySelectorAll('#tabela-barbearias .linha-barbearia');
    
    linhas.forEach(linha => {
        let textoBarbearia = linha.querySelector('td').innerText.toLowerCase();
        if(textoBarbearia.includes(filtro)) {
            linha.style.display = '';
        } else {
            linha.style.display = 'none';
        }
    });
});
</script>