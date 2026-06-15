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

        <h1 class="text-white mb-1">
            Minha Equipe
        </h1>

        <p class="text-secondary">
            Gerencie barbeiros e colaboradores da sua barbearia.
        </p>

    </div>

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h5 class="text-white mb-0">
            Colaboradores
        </h5>

        <a
            href="<?= base_url('dono/equipe/new') ?>"
            class="btn btn-primary">

            <i class="bi bi-person-plus"></i>
            Adicionar Funcionario

        </a>

    </div>

    <div class="card shadow-sm">

        <div class="card-body">

            <table class="table table-hover align-middle mb-0">

                <thead>

                    <tr>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Telefone</th>
                        <th>Cargo</th>
                        <th>Status</th>
                        <th width="150">Ações</th>
                    </tr>

                </thead>

                <tbody>

                    <?php if (!empty($equipe)) : ?>

                        <?php foreach ($equipe as $membro) : ?>

                            <tr>

                                <td><?= $membro->nome ?></td>

                                <td><?= $membro->email ?></td>

                                <td><?= $membro->telefone ?></td>

                                <td><?= ucfirst($membro->cargo) ?></td>

                                <td>

                                    <?php if ($membro->status == 1) : ?>

                                        <span class="badge bg-success">
                                            Ativo
                                        </span>

                                    <?php else : ?>

                                        <span class="badge bg-danger">
                                            Inativo
                                        </span>

                                    <?php endif; ?>

                                </td>

                                <td>

                                    <a
                                        href="#"
                                        class="btn btn-sm btn-warning">

                                        <i class="bi bi-pencil"></i>
                                        Editar

                                    </a>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    <?php else : ?>

                        <tr>

                            <td colspan="6" class="text-center py-5">

                                <i class="bi bi-people fs-1 d-block mb-3"></i>

                                <h5>
                                    Nenhum colaborador cadastrado
                                </h5>

                                <p class="text-muted mb-3">
                                    Adicione o primeiro membro da sua equipe.
                                </p>

                                <a
                                    href="<?= base_url('dono/equipe/new') ?>"
                                    class="btn btn-primary">

                                    <i class="bi bi-person-plus"></i>
                                    Adicionar Barbeiro

                                </a>

                            </td>

                        </tr>

                    <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>