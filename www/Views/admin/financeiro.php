<div class="main-content">

    <div class="mb-4">
        <h1 class="text-white mb-1"><i class="bi bi-currency-dollar text-success me-2"></i>Faturamento Real (SaaS)</h1>
        <p class="text-secondary mb-0">Acompanhe a saúde financeira da sua plataforma baseada nas assinaturas ativas do banco.</p>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card bg-dark border-secondary">
                <div class="card-body">
                    <small class="text-secondary text-uppercase fw-bold" style="font-size: 11px;">Receita Mensal Recorrente (MRR)</small>
                    <h2 class="text-success mt-2 mb-0 fw-bold">R$ <?= number_format($receitaReal, 2, ',', '.') ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-dark border-secondary">
                <div class="card-body">
                    <small class="text-secondary text-uppercase fw-bold" style="font-size: 11px;">Inadimplência Real (Bloqueados)</small>
                    <h2 class="text-danger mt-2 mb-0 fw-bold"><?= number_format($taxaInadimplencia, 1) ?>%</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-dark border-secondary">
                <div class="card-body">
                    <small class="text-secondary text-uppercase fw-bold" style="font-size: 11px;">Empresas Ativas</small>
                    <h2 class="text-info mt-2 mb-0 fw-bold"><?= $ativas ?> ativas</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="card bg-dark border-secondary">
        <div class="card-body p-4">
            <h5 class="text-white mb-4">Fluxo Atual de Assinantes Ativos</h5>
            
            <div class="table-responsive">
                <table class="table table-dark table-hover align-middle mb-0">
                    <thead>
                        <tr class="text-secondary border-secondary">
                            <th>Barbearia Contratante</th>
                            <th>Plano Assinado</th>
                            <th>Data de Cadastro</th>
                            <th>Valor da Mensalidade</th>
                            <th>Situação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($historicoReal)): ?>
                            <?php foreach ($historicoReal as $fatura): ?>
                                <tr class="border-secondary">
                                    <td class="fw-bold text-white"><?= htmlspecialchars($fatura->barbearia_name ?? $fatura->barbearia_nome) ?></td>
                                    <td>
                                        <span class="badge bg-black border border-primary text-primary text-uppercase">
                                            <?= htmlspecialchars($fatura->plano_nome) ?>
                                        </span>
                                    </td>
                                    <td class="text-white-50">
                                        <?= date('d/m/Y', strtotime($fatura->created_at)) ?>
                                    </td>
                                    <td class="text-success fw-bold">
                                        R$ <?= number_format($fatura->plano_preco, 2, ',', '.') ?>
                                    </td>
                                    <td>
                                        <span class="badge bg-success-subtle text-success">Ativo / Pago</span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center py-4 text-secondary">Nenhuma barbearia ativa gerando receita no momento.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>