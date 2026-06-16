<div class="main-content">

    <div class="mb-4">
        <h1 class="text-white mb-1"><i class="bi bi-people-fill text-info me-2"></i>Controle de Usuários</h1>
        <p class="text-secondary mb-0">Lista geral de contas ativas, cargos e mapeamento de empresas vinculadas.</p>
    </div>

    <div class="card bg-dark border-secondary">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-dark table-hover align-middle mb-0">
                    <thead>
                        <tr class="text-secondary border-secondary">
                            <th>Nome</th>
                            <th>E-mail / Login</th>
                            <th>Empresa / Barbearia</th>
                            <th>Cargo</th>
                            <th class="text-center">Status</th>
                            <th class="text-center" width="120">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($usuarios)): ?>
                            <?php foreach($usuarios as $u): ?>
                                <tr class="border-secondary">
                                    <td class="fw-bold text-white"><?= htmlspecialchars($u->nome) ?></td>
                                    <td class="text-white-50"><?= htmlspecialchars($u->email) ?></td>
                                    <td class="text-info fw-bold"><?= htmlspecialchars($u->barbearia_nome ?? 'Administração Master') ?></td>
                                    <td>
                                        <span class="badge <?= $u->cargo == 'admin' ? 'bg-danger' : ($u->cargo == 'dono' ? 'bg-warning text-dark' : 'bg-secondary') ?> text-uppercase">
                                            <?= $u->cargo ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge <?= $u->status == 1 ? 'bg-success' : 'bg-danger' ?>">
                                            <?= $u->status == 1 ? 'Ativo' : 'Bloqueado' ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group gap-1">
                                            <a href="<?= base_url('admin/usuarios/edit?id='.$u->id) ?>" class="btn btn-sm btn-outline-warning" title="Editar Usuário">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center py-4 text-secondary">Nenhum usuário localizado no banco de dados.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>