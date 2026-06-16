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
        <h1 class="text-white">Agenda</h1>
        <p class="text-secondary">Visualize e gerencie os agendamentos da sua barbearia.</p>
    </div>

    <?php if (isset($_SESSION['msg'])): ?>
        <div class="alert alert-<?= $_SESSION['msg']['color'] ?> mb-3">
            <?= $_SESSION['msg']['texto'] ?>
        </div>
        <?php unset($_SESSION['msg']); ?>
    <?php endif; ?>

    <!-- Barra de Filtro de Data -->
    <div class="row g-3 align-items-center mb-4">
        <div class="col-md-4 col-sm-6">
            <div class="input-group">
                <span class="input-group-text bg-dark border-secondary text-white">
                    <i class="bi bi-calendar3"></i>
                </span>
                <input type="date" 
                       id="agenda_filtro_data" 
                       class="form-control bg-dark text-white border-secondary" 
                       value="<?= $dataFiltro ?>">
            </div>
        </div>
        
        <div class="col-md-8 col-sm-6 text-sm-end text-start">
            <a href="<?= base_url('dono/agenda/new') ?>" class="btn btn-primary">
                <i class="bi bi-calendar-plus"></i> Novo Agendamento
            </a>
        </div>
    </div>

    <!-- Tabela -->
    <div class="card border-0 shadow-sm bg-dark">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-dark table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="ps-3">Horário</th>
                            <th>Cliente</th>
                            <th>Barbeiro</th>
                            <th>Serviço</th>
                            <th>Valor</th>
                            <th>Status</th>
                            <th width="100" class="text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>

                    <?php if (!empty($agendamentos)): ?>
                        <?php foreach ($agendamentos as $a): ?>
                            <tr>
                                <td class="ps-3 fw-bold text-info">
                                    <?= date('H:i', strtotime($a->hora_inicio)) ?> - <?= date('H:i', strtotime($a->hora_fim)) ?>
                                </td>
                                <td>
                                    <div class="fw-bold text-white"><?= $a->cliente_nome ?></div>
                                    <small class="text-secondary"><?= $a->cliente_telefone ?></small>
                                </td>
                                <td>
                                    <span class="badge bg-secondary"><?= $a->barbeiro_nome ?></span>
                                </td>
                                <td class="text-white-50">
                                    <?= $a->servico_nome ?>
                                </td>
                                <td class="text-success fw-bold">
                                    R$ <?= number_format($a->valor, 2, ',', '.') ?>
                                </td>
                                <td>
                                    <span class="badge bg-primary text-uppercase">
                                        <?= $a->status ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <button type="button" 
                                            class="btn btn-sm btn-light btn-ver-detalhes"
                                            data-cliente="<?= htmlspecialchars($a->cliente_nome) ?>"
                                            data-telefone="<?= htmlspecialchars($a->cliente_telefone) ?>"
                                            data-barbeiro="<?= htmlspecialchars($a->barbeiro_nome) ?>"
                                            data-servico="<?= htmlspecialchars($a->servico_nome) ?>"
                                            data-horario="<?= date('H:i', strtotime($a->hora_inicio)) ?> - <?= date('H:i', strtotime($a->hora_fim)) ?>"
                                            data-data="<?= date('d/m/Y', strtotime($a->data_agendamento)) ?>"
                                            data-valor="R$ <?= number_format($a->valor, 2, ',', '.') ?>"
                                            data-status="<?= strtoupper($a->status) ?>"
                                            data-obs="<?= htmlspecialchars($a->observacoes) ?>">
                                        <i class="bi bi-eye"></i> Ver
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center py-5 text-secondary">
                                <i class="bi bi-calendar-x fs-1 d-block mb-3 text-muted"></i>
                                <h5>Nenhum agendamento para este dia</h5>
                                <p class="text-muted mb-0">Clique em "Novo Agendamento" para começar.</p>
                            </td>
                        </tr>
                    <?php endif; ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- MODAL POPUP (Inalterado, apenas aguarda o clique do JavaScript) -->
<div class="modal fade" id="modalDetalhesAgenda" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-white border-secondary">
            <div class="modal-header border-secondary">
                <h5 class="modal-title"><i class="bi bi-info-circle text-info me-2"></i>Detalhes</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="text-secondary small d-block">Cliente</label>
                    <span id="modal-txt-cliente" class="fw-bold fs-5 text-white"></span>
                </div>
                <div class="mb-3">
                    <label class="text-secondary small d-block">Telefone</label>
                    <span id="modal-txt-telefone" class="text-white-50"></span>
                </div>
                <hr class="border-secondary">
                <div class="row">
                    <div class="col-6 mb-3">
                        <label class="text-secondary small d-block">Data</label>
                        <span id="modal-txt-data" class="text-white fw-bold"></span>
                    </div>
                    <div class="col-6 mb-3">
                        <label class="text-secondary small d-block">Horário</label>
                        <span id="modal-txt-horario" class="text-info fw-bold"></span>
                    </div>
                    <div class="col-6 mb-3">
                        <label class="text-secondary small d-block">Barbeiro</label>
                        <span id="modal-txt-barbeiro" class="badge bg-secondary fs-6"></span>
                    </div>
                    <div class="col-6 mb-3">
                        <label class="text-secondary small d-block">Serviço</label>
                        <span id="modal-txt-servico" class="text-white-50"></span>
                    </div>
                    <div class="col-6 mb-3">
                        <label class="text-secondary small d-block">Valor</label>
                        <span id="modal-txt-valor" class="text-success fw-bold fs-5"></span>
                    </div>
                    <div class="col-6 mb-3">
                        <label class="text-secondary small d-block">Status</label>
                        <span id="modal-txt-status" class="badge bg-primary"></span>
                    </div>
                </div>
                <hr class="border-secondary">
                <div class="mb-2">
                    <label class="text-secondary small d-block">Observações</label>
                    <p id="modal-txt-obs" class="bg-black p-2 rounded text-white-50 small border border-secondary mt-1" style="min-height: 60px;"></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Escuta a mudança da data
    document.getElementById('agenda_filtro_data').addEventListener('change', function() {
        if (this.value) {
            window.location.href = `<?= base_url('dono/agenda') ?>?data=${this.value}`;
        }
    });

    // Modal
    const botoesVer = document.querySelectorAll('.btn-ver-detalhes');
    const meuModal = new bootstrap.Modal(document.getElementById('modalDetalhesAgenda'));

    botoesVer.forEach(botao => {
        botao.addEventListener('click', function() {
            document.getElementById('modal-txt-cliente').innerText = this.getAttribute('data-cliente');
            document.getElementById('modal-txt-telefone').innerText = this.getAttribute('data-telefone');
            document.getElementById('modal-txt-data').innerText = this.getAttribute('data-data');
            document.getElementById('modal-txt-horario').innerText = this.getAttribute('data-horario');
            document.getElementById('modal-txt-barbeiro').innerText = this.getAttribute('data-barbeiro');
            document.getElementById('modal-txt-servico').innerText = this.getAttribute('data-servico');
            document.getElementById('modal-txt-valor').innerText = this.getAttribute('data-valor');
            document.getElementById('modal-txt-status').innerText = this.getAttribute('data-status');
            
            const obs = this.getAttribute('data-obs');
            document.getElementById('modal-txt-obs').innerText = obs ? obs : 'Nenhuma observação.';

            meuModal.show();
        });
    });
});
</script>