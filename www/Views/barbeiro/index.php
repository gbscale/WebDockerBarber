<?php 
if(isset($_SESSION['usuario_logado'])){
    if($_SESSION['usuario_logado']->cargo == 'barbeiro'){
?>

<div class="main-content">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h1 class="text-white mb-1">
                Dashboard
            </h1>

            <p class="text-secondary mb-0">
                Resumo dos atendimentos do dia.
            </p>
        </div>

        <form method="GET">
            <input
                type="date"
                name="data"
                value="<?= $dataSelecionada ?? date('Y-m-d') ?>"
                class="form-control">
        </form>

    </div>

    <div class="row g-4 mb-4">

        <div class="col-md-4">

            <div class="card">

                <div class="card-body">

                    <small class="text-secondary">
                        Cortes do Dia
                    </small>

                    <h2 class="text-white mt-2">
                        <?= $totalCortes ?? 0 ?>
                    </h2>

                </div>

            </div>

        </div>

        <div class="col-md-4">

            <div class="card">

                <div class="card-body">

                    <small class="text-secondary">
                        Faturamento do Dia
                    </small>

                    <h2 class="text-success mt-2">
                        R$ <?= number_format($faturamentoDia ?? 0, 2, ',', '.') ?>
                    </h2>

                </div>

            </div>

        </div>

        <div class="col-md-4">

            <div class="card">

                <div class="card-body">

                    <small class="text-secondary">
                        Agendamentos
                    </small>

                    <h2 class="text-white mt-2">
                        <?= count($agendamentos ?? []) ?>
                    </h2>

                </div>

            </div>

        </div>

    </div>

    <div class="card">

        <div class="card-body">

            <h5 class="text-white mb-4">
                Agendamentos do Dia
            </h5>

            <table class="table table-hover align-middle mb-0">

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

                                <td>
                                    <?= substr($item->hora_inicio,0,5) ?>
                                </td>

                                <td>
                                    <?= $item->cliente_nome ?>
                                </td>

                                <td>
                                    <?= $item->cliente_telefone ?>
                                </td>

                                <td>

                                    <span class="badge bg-primary">
                                        <?= ucfirst($item->status) ?>
                                    </span>

                                </td>

                                <td>
                                    R$ <?= number_format($item->valor,2,',','.') ?>
                                </td>

                            </tr>

                        <?php endforeach; ?>

                    <?php else: ?>

                        <tr>

                            <td colspan="5" class="text-center py-5">

                                <i class="bi bi-calendar-x fs-1 d-block mb-3"></i>

                                <h5>
                                    Nenhum agendamento encontrado
                                </h5>

                                <p class="text-muted mb-0">
                                    Não existem horários marcados para esta data.
                                </p>

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