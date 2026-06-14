<?php 
if(isset($_SESSION['usuario_logado'])){
    if($_SESSION['usuario_logado']->cargo == 'admin'){
?>

<div class="main-content">

```
<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h1 class="text-white mb-1">
            Painel Administrativo
        </h1>

        <p class="text-secondary mb-0">
            Gerencie todas as barbearias cadastradas na plataforma.
        </p>

    </div>

    <a
        href="<?= base_url('admin/barbearias/new') ?>"
        class="btn btn-primary">

        <i class="bi bi-plus-circle"></i>
        Nova Barbearia

    </a>

</div>

<!-- CARDS -->

<div class="row g-4 mb-4">

    <div class="col-md-3">

        <div class="card">

            <div class="card-body">

                <small class="text-secondary">
                    Barbearias Ativas
                </small>

                <h2 class="text-white mt-2">
                    <?= $totalBarbearias ?? 0 ?>
                </h2>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card">

            <div class="card-body">

                <small class="text-secondary">
                    Usuários Totais
                </small>

                <h2 class="text-white mt-2">
                    <?= $totalUsuarios ?? 0 ?>
                </h2>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card">

            <div class="card-body">

                <small class="text-secondary">
                    Planos Ativos
                </small>

                <h2 class="text-success mt-2">
                    <?= $planosAtivos ?? 0 ?>
                </h2>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card">

            <div class="card-body">

                <small class="text-secondary">
                    Receita Mensal
                </small>

                <h2 class="text-warning mt-2">
                    R$ <?= number_format($receitaMensal ?? 0,2,',','.') ?>
                </h2>

            </div>

        </div>

    </div>

</div>

<!-- TABELA -->

<div class="card">

    <div class="card-body">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <h5 class="text-white mb-0">
                Barbearias Cadastradas
            </h5>

            <input
                type="text"
                class="form-control"
                placeholder="Pesquisar barbearia..."
                style="max-width:300px;">

        </div>

        <table class="table table-hover align-middle mb-0">

            <thead>

                <tr>

                    <th>Barbearia</th>

                    <th>Responsável</th>

                    <th>Plano</th>

                    <th>Usuários</th>

                    <th>Status</th>

                    <th width="180">
                        Ações
                    </th>

                </tr>

            </thead>

            <tbody>

            <?php if(!empty($barbearias)): ?>

                <?php foreach($barbearias as $barbearia): ?>

                    <tr>

                        <td>

                            <strong>
                                <?= $barbearia->nome ?>
                            </strong>

                        </td>

                        <td>

                            <?= $barbearia->responsavel ?>

                        </td>

                        <td>

                            <span class="badge bg-primary">

                                <?= $barbearia->plano ?>

                            </span>

                        </td>

                        <td>

                            <?= $barbearia->usuarios ?? 0 ?>

                        </td>

                        <td>

                            <?php if($barbearia->status == 1): ?>

                                <span class="badge bg-success">
                                    Ativa
                                </span>

                            <?php else: ?>

                                <span class="badge bg-danger">
                                    Suspensa
                                </span>

                            <?php endif; ?>

                        </td>

                        <td>

                            <a
                                href="<?= base_url('admin/barbearias/view/'.$barbearia->id) ?>"
                                class="btn btn-sm btn-info">

                                <i class="bi bi-eye"></i>

                            </a>

                            <a
                                href="<?= base_url('admin/barbearias/edit/'.$barbearia->id) ?>"
                                class="btn btn-sm btn-warning">

                                <i class="bi bi-pencil"></i>

                            </a>

                            <a
                                href="<?= base_url('admin/barbearias/status/'.$barbearia->id) ?>"
                                class="btn btn-sm btn-danger">

                                <i class="bi bi-slash-circle"></i>

                            </a>

                        </td>

                    </tr>

                <?php endforeach; ?>

            <?php else: ?>

                <tr>

                    <td colspan="6" class="text-center py-5">

                        <i class="bi bi-shop fs-1 d-block mb-3"></i>

                        <h5>
                            Nenhuma barbearia cadastrada
                        </h5>

                        <p class="text-muted mb-0">
                            As barbearias cadastradas aparecerão aqui.
                        </p>

                    </td>

                </tr>

            <?php endif; ?>

            </tbody>

        </table>

    </div>

</div>
```

</div>

<?php print_r($_SESSION['usuario_logado']) ?>


<?php
    }else{
        $msg = "Sem permissão de acesso!";
        redirectPage(base_url('login'));
    }
}else{
    $msg = "Sem permissão de acesso!";
        redirectPage(base_url('login'));

}
