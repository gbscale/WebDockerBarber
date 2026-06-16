<div class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="text-white">Minha Agenda</h1>
            <p class="text-secondary">Gerencie exclusivamente os seus horários marcados.</p>
        </div>
        <a href="<?= base_url('barbeiro/agenda/new') ?>" class="btn btn-primary">
            <i class="bi bi-calendar-plus"></i> Novo Agendamento
        </a>
    </div>

    <?php if (isset($_SESSION['msg'])): ?>
        <div class="alert alert-<?= $_SESSION['msg']['color'] ?> mb-3"><?= $_SESSION['msg']['texto'] ?></div>
        <?php unset($_SESSION['msg']); ?>
    <?php endif; ?>

    <div class="card bg-dark border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-dark table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="ps-3">Data/Hora</th>
                            <th>Cliente</th>
                            <th>Serviço</th>
                            <th>Status</th>
                            <th width="100" class="text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($agendamentos)): ?>
                        <?php foreach ($agendamentos as $a): ?>
                            <tr>
                                <td class="ps-3">
                                    <span class="d-block fw-bold text-info"><?= date('d/m/Y', strtotime($a->data_agendamento)) ?></span>
                                    <small class="text-secondary"><?= substr($a->hora_inicio,0,5) ?> - <?= substr($a->hora_fim,0,5) ?></small>
                                </td>
                                <td class="fw-bold"><?= htmlspecialchars($a->cliente_nome) ?></td>
                                <td class="text-white-50"><?= htmlspecialchars($a->servico_nome) ?></td>
                                <td>
                                    <span class="badge <?= $a->status == 'cancelado' ? 'bg-danger' : 'bg-primary' ?> text-uppercase"><?= $a->status ?></span>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-light btn-ver-detalhes" 
                                            data-cliente="<?= htmlspecialchars($a->cliente_nome) ?>"
                                            data-telefone="<?= htmlspecialchars($a->cliente_telefone) ?>"
                                            data-servico="<?= htmlspecialchars($a->servico_nome) ?>"
                                            data-horario="<?= substr($a->hora_inicio,0,5) ?> às <?= substr($a->hora_fim,0,5) ?>"
                                            data-data="<?= date('d/m/Y', strtotime($a->data_agendamento)) ?>"
                                            data-valor="R$ <?= number_format($a->valor, 2, ',', '.') ?>"
                                            data-status="<?= strtoupper($a->status) ?>"
                                            data-obs="<?= htmlspecialchars($a->observacoes ?? 'Sem observações.') ?>">
                                        <i class="bi bi-eye"></i> Ver
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center py-5 text-secondary">
                                <i class="bi bi-calendar-x fs-1 d-block mb-3"></i>
                                <h5>Nenhum agendamento encontrado</h5>
                            </td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detalhes Simples -->
<div class="modal fade" id="modalBarbeiroVer" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-white border-secondary">
            <div class="modal-header border-secondary">
                <h5 class="modal-title">Detalhes do Atendimento</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p><strong>Cliente:</strong> <span id="m-cliente"></span></p>
                <p><strong>Telefone:</strong> <span id="m-telefone"></span></p>
                <p><strong>Serviço:</strong> <span id="m-servico"></span></p>
                <p><strong>Data/Horário:</strong> <span id="m-data"></span> - <span id="m-hora"></span></p>
                <p><strong>Preço cobrado:</strong> <span id="m-valor" class="text-success"></span></p>
                <p><strong>Observações:</strong></p>
                <p id="m-obs" class="bg-black p-2 rounded text-white-50 small"></p>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const modal = new bootstrap.Modal(document.getElementById('modalBarbeiroVer'));
    document.querySelectorAll('.btn-ver-detalhes').forEach(btn => {
        btn.addEventListener('click', function() {
            document.getElementById('m-cliente').innerText = this.getAttribute('data-cliente');
            document.getElementById('m-telefone').innerText = this.getAttribute('data-telefone');
            document.getElementById('m-servico').innerText = this.getAttribute('data-servico');
            document.getElementById('m-data').innerText = this.getAttribute('data-data');
            document.getElementById('m-hora').innerText = this.getAttribute('data-horario');
            document.getElementById('m-valor').innerText = this.getAttribute('data-valor');
            document.getElementById('m-obs').innerText = this.getAttribute('data-obs');
            modal.show();
        });
    });
});
</script>