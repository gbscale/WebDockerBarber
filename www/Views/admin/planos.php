<div class="main-content">

    <div class="mb-4 d-flex justify-content-between align-items-center">
        <div>
            <h1 class="text-white mb-1"><i class="bi bi-card-checklist text-primary me-2"></i>Planos & Assinaturas</h1>
            <p class="text-secondary mb-0">Configure os modelos de negócio e valores cobrados mensalmente das barbearias.</p>
        </div>
        <button class="btn btn-primary fw-bold" data-bs-toggle="modal" data-bs-target="#modalPlano" onclick="configurarModalNovo()">
            <i class="bi bi-plus-lg me-2"></i>Criar Novo Plano
        </button>
    </div>

    <?php if (isset($_SESSION['msg'])): ?>
        <div class="alert alert-<?= $_SESSION['msg']['color'] ?> mb-4 shadow"><?= $_SESSION['msg']['texto'] ?></div>
        <?php unset($_SESSION['msg']); ?>
    <?php endif; ?>

    <div class="row g-4">
        
        <?php if (!empty($planos)): ?>
            <?php foreach ($planos as $index => $plano): ?>
                <?php 
                    // Estilização dinâmica baseada na posição ou preço do plano
                    $isPro = ($index == 1); // O segundo plano ganha destaque azul (Pro)
                    $isGold = ($index >= 2); // O terceiro plano ou mais ganha destaque dourado
                    
                    $cardBorder = 'border-secondary';
                    $btnClass = 'btn-outline-light border-secondary';
                    $badgeClass = 'bg-secondary';
                    $badgeText = 'Plano Inicial';

                    if ($isPro) {
                        $cardBorder = 'border-primary';
                        $btnClass = 'btn-primary';
                        $badgeClass = 'bg-primary';
                        $badgeText = 'Mais Vendido';
                    } elseif ($isGold) {
                        $cardBorder = 'border-warning';
                        $btnClass = 'btn-outline-warning';
                        $badgeClass = 'bg-warning text-dark';
                        $badgeText = 'Alta Performance';
                    }
                ?>
                <div class="col-md-4">
                    <div class="card bg-dark <?= $cardBorder ?> h-100 text-white" <?= $isPro ? 'style="box-shadow: 0 4px 15px rgba(13, 110, 253, 0.15);"' : '' ?>>
                        <div class="card-body p-4 d-flex flex-column">
                            <span class="badge <?= $badgeClass ?> text-uppercase align-self-start mb-2"><?= $badgeText ?></span>
                            <h4 class="fw-bold mb-0"><?= htmlspecialchars($plano->nome) ?></h4>
                            <h2 class="text-success my-3 fw-bold">R$ <?= number_format($plano->preco, 2, ',', '.') ?> <span class="text-secondary fs-6">/mês</span></h2>
                            
                            <ul class="list-unstyled my-4 flex-grow-1">
                                <li class="mb-2">
                                    <i class="bi bi-check2 text-success me-2"></i> 
                                    Limite de <strong><?= $plano->limite_cortes >= 9000 ? 'Cortes Ilimitados' : $plano->limite_cortes . ' cortes' ?></strong> por mês
                                </li>
                                <li class="mb-2"><i class="bi bi-check2 text-success me-2"></i> Agenda Inteligente</li>
                                <li class="mb-2"><i class="bi bi-check2 text-success me-2"></i> Relatórios de Faturamento</li>
                                <li class="text-white-50 small mt-3 border-top border-secondary pt-3">ID do Plano: #<?= $plano->id ?></li>
                            </ul>
                            
                            <div class="d-grid gap-2 mt-auto">
                                <button class="btn <?= $btnClass ?> fw-bold" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#modalPlano"
                                        onclick='configurarModalEditar(<?= json_encode($plano) ?>)'>
                                    <i class="bi bi-pencil me-2"></i>Editar Configurações
                                </button>
                                <a href="<?= base_url('admin/planos/delete?id=' . $plano->id) ?>" 
                                   class="btn btn-sm btn-outline-danger border-0" 
                                   onclick="return confirm('Tem certeza que deseja excluir este plano?')">
                                    <i class="bi bi-trash me-1"></i> Excluir Plano
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center py-5 text-secondary">
                <i class="bi bi-card-disconnect fs-1 d-block mb-3 text-muted"></i>
                <h5 class="text-white">Nenhum plano cadastrado</h5>
                <p class="text-muted small">Clique no botão superior para criar os pacotes do seu SaaS.</p>
            </div>
        <?php endif; ?>

    </div>
</div>

<div class="modal fade" id="modalPlano" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-white border-secondary">
            <div class="modal-header border-secondary bg-black">
                <h5 class="modal-title" id="modalTitulo">Criar Novo Plano</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="<?= base_url('admin/planos/save') ?>">
                <input type="hidden" name="id" id="plano_id">
                
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label text-white-50">Nome do Plano</label>
                        <input type="text" name="nome" id="plano_nome" class="form-control bg-black text-white border-secondary" required placeholder="Ex: Easy Ultimate">
                    </div>
                    <div class="row g-3">
                        <div class="col-6">
                            <label class="form-label text-white-50">Preço Mensal (R$)</label>
                            <input type="number" step="0.01" name="preco" id="plano_preco" class="form-control bg-black text-white border-secondary" required placeholder="119.90">
                        </div>
                        <div class="col-6">
                            <label class="form-label text-white-50">Cortes no Mês</label>
                            <input type="number" name="limite_cortes" id="plano_limite" class="form-control bg-black text-white border-secondary" required placeholder="Ex: 500 (9999 p/ Ilimitado)">
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-secondary bg-black">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary fw-bold">Salvar Plano</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function configurarModalNovo() {
    document.getElementById('modalTitulo').innerText = 'Criar Novo Plano';
    document.getElementById('plano_id').value = '';
    document.getElementById('plano_nome').value = '';
    document.getElementById('plano_preco').value = '';
    document.getElementById('plano_limite').value = '';
}

function configurarModalEditar(plano) {
    document.getElementById('modalTitulo').innerText = 'Editar Plano #' + plano.id;
    document.getElementById('plano_id').value = plano.id;
    document.getElementById('plano_nome').value = plano.nome;
    document.getElementById('plano_preco').value = plano.preco;
    document.getElementById('plano_limite').value = plano.limite_cortes;
}
</script>