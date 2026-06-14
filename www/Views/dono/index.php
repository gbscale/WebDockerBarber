<?php 
if(isset($_SESSION['usuario_logado'])){
    if($_SESSION['usuario_logado']->cargo == 'dono'){
?>

<div class="main-content">

```
<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h1 class="text-white mb-1">
            Dashboard da Barbearia
        </h1>

        <p class="text-secondary mb-0">
            Visão geral do desempenho da sua barbearia.
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

<!-- Indicadores principais -->

<div class="row g-4 mb-4">

    <div class="col-md-3">

        <div class="card">
            <div class="card-body">

                <small class="text-secondary">
                    Faturamento Hoje
                </small>

                <h2 class="text-success mt-2">
                    R$ <?= number_format($faturamentoHoje ?? 0,2,',','.') ?>
                </h2>

            </div>
        </div>

    </div>

    <div class="col-md-3">

        <div class="card">
            <div class="card-body">

                <small class="text-secondary">
                    Agendamentos Hoje
                </small>

                <h2 class="text-white mt-2">
                    <?= $totalAgendamentos ?? 0 ?>
                </h2>

            </div>
        </div>

    </div>

    <div class="col-md-3">

        <div class="card">
            <div class="card-body">

                <small class="text-secondary">
                    Clientes Atendidos
                </small>

                <h2 class="text-white mt-2">
                    <?= $clientesAtendidos ?? 0 ?>
                </h2>

            </div>
        </div>

    </div>

    <div class="col-md-3">

        <div class="card">
            <div class="card-body">

                <small class="text-secondary">
                    Barbeiros Ativos
                </small>

                <h2 class="text-white mt-2">
                    <?= $barbeirosAtivos ?? 0 ?>
                </h2>

            </div>
        </div>

    </div>

</div>

<!-- Indicadores secundários -->

<div class="row g-4 mb-4">

    <div class="col-md-3">

        <div class="card">
            <div class="card-body">

                <small class="text-secondary">
                    Faturamento do Mês
                </small>

                <h3 class="text-success mt-2">
                    R$ <?= number_format($faturamentoMes ?? 0,2,',','.') ?>
                </h3>

            </div>
        </div>

    </div>

    <div class="col-md-3">

        <div class="card">
            <div class="card-body">

                <small class="text-secondary">
                    Ticket Médio
                </small>

                <h3 class="text-info mt-2">
                    R$ <?= number_format($ticketMedio ?? 0,2,',','.') ?>
                </h3>

            </div>
        </div>

    </div>

    <div class="col-md-3">

        <div class="card">
            <div class="card-body">

                <small class="text-secondary">
                    Serviço Mais Vendido
                </small>

                <h6 class="text-warning mt-3">
                    <?= $servicoMaisVendido ?? '---' ?>
                </h6>

            </div>
        </div>

    </div>

    <div class="col-md-3">

        <div class="card">
            <div class="card-body">

                <small class="text-secondary">
                    Ocupação do Dia
                </small>

                <h3 class="text-primary mt-2">
                    <?= $taxaOcupacao ?? 0 ?>%
                </h3>

            </div>
        </div>

    </div>

</div>

<!-- Agendamentos -->

<div class="card mb-4">

    <div class="card-body">

        <h5 class="text-white mb-4">
            Agendamentos do Dia
        </h5>

        <table class="table table-hover align-middle">

            <thead>

                <tr>
                    <th>Horário</th>
                    <th>Cliente</th>
                    <th>Barbeiro</th>
                    <th>Serviço</th>
                    <th>Status</th>
                    <th>Valor</th>
                </tr>

            </thead>

            <tbody>

            <?php if(!empty($agendamentos)): ?>

                <?php foreach($agendamentos as $item): ?>

                    <tr>

                        <td><?= substr($item->hora_inicio,0,5) ?></td>

                        <td><?= $item->cliente_nome ?></td>

                        <td><?= $item->barbeiro_nome ?></td>

                        <td><?= $item->servico_nome ?></td>

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

                    <td colspan="6" class="text-center py-5">

                        <i class="bi bi-calendar-x fs-1 d-block mb-3"></i>

                        <h5>
                            Nenhum agendamento encontrado
                        </h5>

                    </td>

                </tr>

            <?php endif; ?>

            </tbody>

        </table>

    </div>

</div>

<!-- Ranking -->

<div class="card">

    <div class="card-body">

        <h5 class="text-white mb-4">
            Ranking de Barbeiros
        </h5>

        <table class="table table-hover align-middle">

            <thead>

                <tr>
                    <th>Barbeiro</th>
                    <th>Atendimentos</th>
                    <th>Faturamento</th>
                </tr>

            </thead>

            <tbody>

            <?php if(!empty($rankingBarbeiros)): ?>

                <?php foreach($rankingBarbeiros as $barbeiro): ?>

                    <tr>

                        <td><?= $barbeiro->nome ?></td>

                        <td><?= $barbeiro->total_atendimentos ?></td>

                        <td>
                            R$ <?= number_format($barbeiro->faturamento,2,',','.') ?>
                        </td>

                    </tr>

                <?php endforeach; ?>

            <?php else: ?>

                <tr>

                    <td colspan="3" class="text-center py-4">
                        Nenhum dado encontrado.
                    </td>

                </tr>

            <?php endif; ?>

            </tbody>

        </table>

    </div>

</div>
```

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