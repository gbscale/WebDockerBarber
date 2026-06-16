<div class="main-content">
    <div class="mb-4">
        <h1 class="text-white">Tabela de Serviços</h1>
        <p class="text-secondary">Lista de serviços e valores oficiais configurados pela gerência.</p>
    </div>

    <div class="card bg-dark border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-dark table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="ps-3">Nome do Serviço</th>
                            <th>Duração estimada</th>
                            <th>Preço do catálogo</th>
                            <th>Status no Sistema</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($servicos)): ?>
                            <?php foreach($servicos as $servico): ?>
                                <tr>
                                    <td class="ps-3 fw-bold"><?= htmlspecialchars($servico->nome) ?></td>
                                    <td><i class="bi bi-clock me-1 text-info"></i> <?= $servico->duracao ?> min</td>
                                    <td class="text-success fw-bold">R$ <?= number_format($servico->valor, 2, ',', '.') ?></td>
                                    <td>
                                        <span class="badge <?= $servico->status == 1 ? 'bg-success' : 'bg-danger' ?>">
                                            <?= $servico->status == 1 ? 'Ativo' : 'Inativo' ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center py-4 text-secondary">Nenhum serviço cadastrado pela gerência.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>