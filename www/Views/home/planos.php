<header class="bg-dark text-white text-center py-5" style="background: linear-gradient(135deg, #111 0%, #1a1a1a 100%); border-bottom: 1px solid #333;">
    <div class="container py-4">
        <h1 class="display-4 fw-bold">Planos que cabem no seu bolso</h1>
        <p class="lead text-secondary">Seja você uma barbearia individual ou uma grande rede de franquias.</p>
    </div>
</header>

<section class="py-5 bg-black text-white">
    <div class="container">
        <div class="row justify-content-center g-4">
            
            <?php if (!empty($planos)): ?>
                <?php foreach ($planos as $index => $plano): ?>
                    <?php 
                        // 🌟 Configura o destaque automático para o segundo plano cadastrado (índice 1)
                        $isPopular = ($index == 1); 
                        
                        $cardClass = $isPopular ? 'border-danger shadow' : 'border-secondary';
                        $cardStyle = $isPopular ? 'style="transform: scale(1.03);"' : '';
                        $headerClass = $isPopular ? 'bg-danger text-white border-0' : 'border-secondary';
                        $btnClass = $isPopular ? 'btn-danger fw-bold shadow' : 'btn-outline-light';
                        $iconColor = $isPopular ? 'text-white' : 'text-danger';
                    ?>
                    
                    <div class="col-md-4 mb-4">
                        <div class="card bg-dark text-white <?= $cardClass ?> h-100" <?= $cardStyle ?>>
                            
                            <div class="card-header text-center <?= $headerClass ?> py-4">
                                <?php if ($isPopular): ?>
                                    <span class="badge bg-white text-danger fw-bold mb-2 text-uppercase">MAIS POPULAR</span>
                                <?php endif; ?>
                                
                                <h3 class="fw-bold mb-1 <?= !$isPopular && $index == 2 ? 'text-warning' : '' ?>">
                                    <?= htmlspecialchars($plano->nome) ?>
                                </h3>
                                
                                <p class="text-muted small mb-3">
                                    <?= $plano->preco == 0 ? 'Ideal para quem está começando' : 'O empurrão perfeito para o seu negócio' ?>
                                </p>
                                
                                <h2 class="fw-bold mb-0">
                                    <?php if ($plano->preco == 0): ?>
                                        Grátis
                                    <?php else: ?>
                                        R$ <?= number_format($plano->preco, 2, ',', '.') ?><span class="fs-6 fw-normal text-white-50">/mês</span>
                                    <?php endif; ?>
                                </h2>
                            </div>
                            
                            <div class="card-body py-4 d-flex flex-column justify-content-between">
                                <ul class="list-unstyled mb-4">
                                    <li class="mb-2">
                                        <i class="bi bi-check2 <?= $iconColor ?> me-2"></i>
                                        Limite de <strong><?= $plano->limite_cortes >= 9000 ? 'Cortes Ilimitados' : $plano->limite_cortes . ' cortes' ?></strong> por mês
                                    </li>
                                    <li class="mb-2"><i class="bi bi-check2 <?= $iconColor ?> me-2"></i>Agenda Online Inteligente</li>
                                    <li class="mb-2"><i class="bi bi-check2 <?= $iconColor ?> me-2"></i>Painel Financeiro de Caixa</li>
                                    <li class="mb-2"><i class="bi bi-check2 <?= $iconColor ?> me-2"></i>Suporte técnico integrado</li>
                                </ul>
                                
                                <div class="d-grid mt-auto">
                                    <a href="<?= base_url('usuarios/new?plano=' . $plano->id) ?>" class="btn <?= $btnClass ?>">
                                        <?= $plano->preco == 0 ? 'Começar Agora' : 'Assinar Plano' ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center py-5 text-secondary">
                    <p class="lead">Nenhum plano disponível no momento. Volte mais tarde!</p>
                </div>
            <?php endif; ?>

        </div>
    </div>
</section>