<!-- Cabeçalho -->
<header class="bg-dark text-white text-center py-5" style="background: linear-gradient(135deg, #111 0%, #1a1a1a 100%); border-bottom: 1px solid #333;">
    <div class="container py-4">
        <h1 class="display-4 fw-bold">Planos que cabem no seu bolso</h1>
        <p class="lead text-secondary">Seja você uma barbearia individual ou uma grande rede de franquias.</p>
    </div>
</header>

<!-- Seção de Planos de Barbearia -->
<section class="py-5 bg-black text-white">
    <div class="container">
        <div class="row justify-content-center">
            
            <!-- Plano Bronze -->
            <div class="col-md-4 mb-4">
                <div class="card bg-dark text-white border-secondary h-100">
                    <div class="card-header text-center border-secondary py-4">
                        <h3 class="fw-bold mb-1 text-secondary">Bronze</h3>
                        <p class="text-muted small mb-3">Ideal para quem está começando</p>
                        <h2 class="fw-bold mb-0 text-white">Grátis</h2>
                    </div>
                    <div class="card-body py-4">
                        <ul class="list-unstyled space-y-2">
                            <li class="mb-2"><i class="bi bi-check2 text-danger me-2"></i>Até 1 Barbeiro Cadastrado</li>
                            <li class="mb-2"><i class="bi bi-check2 text-danger me-2"></i>Agenda Online Simplificada</li>
                            <li class="mb-2 text-white-50"><i class="bi bi-x text-muted me-2"></i>Sem Relatórios Financeiros</li>
                        </ul>
                        <div class="d-grid mt-4">
                            <a href="<?= base_url('usuarios/new') ?>" class="btn btn-outline-light">Começar Agora</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Plano Prata -->
            <div class="col-md-4 mb-4">
                <div class="card bg-dark text-white border-danger h-100 shadow" style="transform: scale(1.03);">
                    <div class="card-header text-center bg-danger text-white border-0 py-4">
                        <span class="badge bg-white text-danger fw-bold mb-2 uppercase">MAIS POPULAR</span>
                        <h3 class="fw-bold mb-1">Prata Pro</h3>
                        <p class="text-white-50 small mb-3">O empurrão perfeito para o sucesso</p>
                        <h2 class="fw-bold mb-0">R$ 49,90<span class="fs-6 fw-normal">/mês</span></h2>
                    </div>
                    <div class="card-body py-4">
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="bi bi-check2 text-white me-2"></i>Até 5 Barbeiros Cadastrados</li>
                            <li class="mb-2"><i class="bi bi-check2 text-white me-2"></i>Agenda Online Avançada</li>
                            <li class="mb-2"><i class="bi bi-check2 text-white me-2"></i>Painel de Finanças e Caixa</li>
                            <li class="mb-2"><i class="bi bi-check2 text-white me-2"></i>Suporte via WhatsApp</li>
                        </ul>
                        <div class="d-grid mt-4">
                            <a href="<?= base_url('usuarios/new') ?>" class="btn btn-danger fw-bold shadow">Assinar Plano</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Plano Ouro -->
            <div class="col-md-4 mb-4">
                <div class="card bg-dark text-white border-secondary h-100">
                    <div class="card-header text-center border-secondary py-4">
                        <h3 class="fw-bold mb-1 text-warning">Ouro Premium</h3>
                        <p class="text-muted small mb-3">Controle total para grandes operações</p>
                        <h2 class="fw-bold mb-0 text-white">R$ 99,90<span class="fs-6 fw-normal">/mês</span></h2>
                    </div>
                    <div class="card-body py-4">
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="bi bi-check2 text-danger me-2"></i>Barbeiros **Ilimitados**</li>
                            <li class="mb-2"><i class="bi bi-check2 text-danger me-2"></i>Agenda Online customizável</li>
                            <li class="mb-2"><i class="bi bi-check2 text-danger me-2"></i>Relatórios de Métricas Avançados</li>
                            <li class="mb-2"><i class="bi bi-check2 text-danger me-2"></i>Gerente de Conta Dedicado</li>
                        </ul>
                        <div class="d-grid mt-4">
                            <a href="<?= base_url('usuarios/new') ?>" class="btn btn-outline-warning">Contratar Premium</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>