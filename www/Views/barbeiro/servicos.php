<?php 
if(isset($_SESSION['usuario_logado'])){
    if($_SESSION['usuario_logado']->cargo == 'barbeiro'){
?>

<div class="main-content">

    <div class="mb-4">

        <h1 class="text-white">
            Serviços
        </h1>

        <p class="text-secondary">
            Gerencie os serviços da barbearia.
        </p>

    </div>

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h5 class="text-white mb-0">
            Todos os serviços
        </h5>

        <a href="<?= base_url('dono/servicos/new') ?>"
           class="btn btn-primary">

            <i class="bi bi-plus-circle"></i>
            Novo Serviço

        </a>

    </div>

    <div class="card border-0 shadow-sm">

        <div class="card-body">

            <table class="table table-hover align-middle mb-0">

                <thead>

                    <tr>
                        <th>Nome</th>
                        <th>Duração</th>
                        <th>Preço</th>
                        <th>Status</th>
                        <th width="150">Ações</th>
                    </tr>

                </thead>

                <tbody>

                    <?php if(!empty($servicos)): ?>

                        <?php foreach($servicos as $servico): ?>

                            <tr>

                                <td>
                                    <?= $servico->nome ?>
                                </td>

                                <td>
                                    <?= $servico->duracao ?> min
                                </td>

                                <td>
                                    R$ <?= number_format($servico->valor, 2, ',', '.') ?>
                                </td>

                                <td>

                                    <?php if($servico->status == 1): ?>

                                        <span class="badge bg-success">
                                            Ativo
                                        </span>

                                    <?php else: ?>

                                        <span class="badge bg-danger">
                                            Inativo
                                        </span>

                                    <?php endif; ?>

                                </td>

                                <td>

                                    <a
                                        href="<?= base_url('barbeiro/servicos/edit/'.$servico->id) ?>"
                                        class="btn btn-sm btn-warning">

                                        <i class="bi bi-pencil"></i>

                                    </a>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    <?php else: ?>

                        <tr>

                            <td colspan="5" class="text-center">

                                Nenhum serviço cadastrado.

                            </td>

                        </tr>

                    <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

<?php
    }else{
        $msg = "Sem permissão de acesso!";
        redirectPage(base_url('login'));
    }
}else{
    $msg = "Sem permissão de acesso!";
        redirectPage(base_url('login'));

}