<div class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="text-white mb-1">Meu Dashboard</h1>
            <p class="text-secondary mb-0">Resumo dos seus atendimentos pessoais.</p>
        </div>
        <form method="GET" id="form-filtro-data">
            <input type="date" name="data" value="<?= $dataSelecionada ?? date('Y-m-d') ?>" class="form-control bg-dark text-white border-secondary" onchange="document.getElementById('form-filtro-data').submit();">
        </form>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card bg-dark border-secondary">
                <div class="card-body">
                    <small class="text-secondary">Meus Atendimentos (Hoje)</small>
                    <h2 class="text-white mt-2"><?= $totalCortes ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-dark border-secondary">
                <div class="card-body">
                    <small class="text-secondary">Minha Produção (Hoje)</small>
                    <h2 class="text-success mt-2">R$ <?= number_format($faturamentoDia, 2, ',', '.') ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-dark border-secondary">
                <div class="card-body">
                    <small class="text-secondary">Total Listado</small>
                    <h2 class="text-info mt-2"><?= count($agendamentos) ?></h2>
                </div>
            </div>
        </div>
    </div>

    <div class="card bg-dark border-0">
        <div class="card-body">
            <h5 class="text-white mb-4">Minha Agenda do Dia</h5>
            <div class="table-responsive">
                <table class="table table-dark table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Horário</th>
                            <th>Cliente</th>
                            <th>Telefone</th>
                            <th>Status</th>
                            <th>Valor</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($agendamentos)): ?>
                            <?php foreach($agendamentos as $item): ?>
                                <tr>
                                    <td class="text-info fw-bold"><?= substr($item->hora_inicio, 0, 5) ?></td>
                                    <td><?= htmlspecialchars($item->cliente_nome) ?></td>
                                    <td class="text-white-50"><?= htmlspecialchars($item->cliente_telefone) ?></td>
                                    <td>
                                        <span class="badge <?= $item->status == 'cancelado' ? 'bg-danger' : ($item->status == 'finalizado' ? 'bg-success' : 'bg-warning text-dark') ?>">
                                            <?= strtoupper($item->status) ?>
                                        </span>
                                    </td>
                                    <td class="text-success fw-bold">R$ <?= number_format($item->valor, 2, ',', '.') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center py-5 text-secondary">
                                    <i class="bi bi-calendar-x fs-1 d-block mb-3"></i>
                                    <h5>Nenhum agendamento para você nesta data.</h5>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>