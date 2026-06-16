<?php
if (!isset($_SESSION['usuario_logado']) || $_SESSION['usuario_logado']->cargo != 'dono') {
    redirectPage(base_url('login'));
    exit;
}
?>

<div class="main-content">

    <div class="mb-4">
        <h1 class="text-white mb-1">Configurações</h1>
        <p class="text-secondary">Gerencie sua conta, dados da empresa e seu plano de assinatura.</p>
    </div>

    <!-- Mensagens de Feedback -->
    <?php if (isset($_SESSION['msg'])): ?>
        <div class="alert alert-<?= $_SESSION['msg']['color'] ?> mb-4"><?= $_SESSION['msg']['texto'] ?></div>
        <?php unset($_SESSION['msg']); ?>
    <?php endif; ?>

    <form method="POST" action="<?= base_url('dono/configuracoes/save') ?>">

        <div class="row g-4">

            <!-- 1. DADOS DA BARBEARIA -->
            <div class="col-lg-4">
                <div class="card h-100 bg-dark text-white border-secondary">
                    <div class="card-body">
                        <h5 class="text-white mb-4"><i class="bi bi-shop me-2 text-warning"></i>Dados da Barbearia</h5>

                        <div class="mb-3">
                            <label class="form-label text-white-50">Nome da Barbearia</label>
                            <input type="text" name="nome_barbearia" class="form-control bg-black text-white border-secondary" value="<?= htmlspecialchars($barbearia->nome ?? '') ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-white-50">Telefone Comercial</label>
                            <input type="text" name="telefone_barbearia" class="form-control bg-black text-white border-secondary" value="<?= htmlspecialchars($barbearia->telefone ?? '') ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-white-50">E-mail da Barbearia</label>
                            <input type="email" name="email_barbearia" class="form-control bg-black text-white border-secondary" value="<?= htmlspecialchars($barbearia->email ?? '') ?>">
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. MINHA CONTA (DONO) -->
            <div class="col-lg-4">
                <div class="card h-100 bg-dark text-white border-secondary">
                    <div class="card-body">
                        <h5 class="text-white mb-4"><i class="bi bi-person-circle me-2 text-warning"></i>Minha Conta</h5>

                        <div class="mb-3">
                            <label class="form-label text-white-50">Seu Nome</label>
                            <input type="text" name="nome" class="form-control bg-black text-white border-secondary" value="<?= htmlspecialchars($usuario->nome ?? '') ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-white-50">E-mail de Login</label>
                            <input type="email" name="email" class="form-control bg-black text-white border-secondary" value="<?= htmlspecialchars($usuario->email ?? '') ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-white-50">Telefone Pessoal</label>
                            <input type="text" name="telefone" class="form-control bg-black text-white border-secondary" value="<?= htmlspecialchars($usuario->telefone ?? '') ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-warning">Nova Senha</label>
                            <input type="password" name="senha" class="form-control bg-black text-white border-warning" placeholder="Deixe em branco para manter a atual">
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3. PLANO DE ASSINATURA -->
            <div class="col-lg-4">
                <div class="card h-100 bg-dark text-white border-secondary">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="text-white mb-4"><i class="bi bi-credit-card me-2 text-warning"></i>Plano de Assinatura</h5>
                            
                            <div class="mb-4">
                                <label class="form-label text-white-50 d-block">Selecione seu Plano Atual:</label>
                                <select name="plano_id" class="form-select bg-black text-white border-secondary py-2" required>
                                    <option value="" disabled>Escolha um plano...</option>
                                    <?php foreach ($planosDisponiveis as $plano): ?>
                                        <?php $selecionado = (isset($barbearia->plano_id) && $barbearia->plano_id == $plano->id) ? 'selected' : ''; ?>
                                        <option value="<?= $plano->id ?>" <?= $selecionado ?>>
                                            <?= htmlspecialchars($plano->nome) ?> — R$ <?= number_format($plano->preco, 2, ',', '.') ?>/mês
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Pequeno Informativo Dinâmico sobre o Plano Selecionado Atualmente -->
                            <div class="p-3 bg-black rounded border border-secondary">
                                <div class="small text-white-50 mb-1"><i class="bi bi-info-circle me-1 text-info"></i> Detalhes do sistema:</div>
                                <p class="small text-secondary mb-0">Caso mude de plano, os novos limites e faturamento recorrente serão aplicados no próximo ciclo de cobrança.</p>
                            </div>
                        </div>

                        <div class="text-center mt-3 text-secondary small">
                            Precisa de ajuda? <a href="#" class="text-warning text-decoration-none">Contatar Suporte Master</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Botão de Ação Global -->
        <div class="mt-4 text-end">
            <button type="submit" class="btn btn-warning btn-lg px-4 fw-bold">
                <i class="bi bi-check-lg me-2"></i>Salvar Todas as Alterações
            </button>
        </div>

    </form>
</div>