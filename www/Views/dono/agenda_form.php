<?php 
if(isset($_SESSION['usuario_logado'])){
    if($_SESSION['usuario_logado']->cargo == 'dono'){
?>

<?php
if(
    !isset($_SESSION['usuario_logado']) ||
    $_SESSION['usuario_logado']->cargo != 'dono'
){
    redirectPage(base_url('login'));
    exit;
}
?>

<div class="main-content">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h1 class="text-white">
                Novo Agendamento
            </h1>

            <p class="text-secondary">
                Crie um agendamento manualmente.
            </p>

        </div>

        <a href="<?= base_url('dono/agenda') ?>"
           class="btn btn-secondary">

            <i class="bi bi-arrow-left"></i>
            Voltar

        </a>

    </div>

    <form method="POST"
          action="<?= base_url('dono/agenda/save') ?>">

        <div class="card dashboard-card">

            <div class="card-body">

                <div class="row">

                    <!-- Cliente -->
                    <div class="col-md-6 mb-3">

                        <label class="form-label">Cliente</label>

                        <input type="text"
                               name="cliente_nome"
                               class="form-control"
                               required>

                    </div>

                    <!-- Telefone -->
                    <div class="col-md-6 mb-3">

                        <label class="form-label">Telefone</label>

                        <input type="text"
                               name="cliente_telefone"
                               class="form-control"
                               required>

                    </div>

                    <!-- Barbeiro -->
                    <div class="col-md-6 mb-3">

                        <label class="form-label">Barbeiro</label>

                        <select name="barbeiro_id"
                                class="form-select"
                                required>

                            <option value="">Selecione</option>

                            <?php foreach($barbeiros as $barbeiro): ?>
                                <option value="<?= $barbeiro->id ?>">
                                    <?= $barbeiro->nome ?>
                                </option>
                            <?php endforeach; ?>

                        </select>

                    </div>

                    <!-- Serviço -->
                    <div class="col-md-6 mb-3">

                        <label class="form-label">Serviço</label>

                        <select name="servico_id"
                                class="form-select"
                                required>

                            <option value="">Selecione</option>

                            <?php foreach($servicos as $servico): ?>
                                <option value="<?= $servico->id ?>">
                                    <?= $servico->nome ?> -
                                    R$ <?= number_format($servico->preco,2,',','.') ?>
                                </option>
                            <?php endforeach; ?>

                        </select>

                    </div>

                    <!-- Data -->
                    <div class="col-md-6 mb-3">

                        <label class="form-label">Data</label>

                        <input type="date"
                               name="data_agendamento"
                               class="form-control"
                               required>

                    </div>

                    <!-- Hora início (CORRETO) -->
                    <div class="col-md-6 mb-3">

                        <label class="form-label">Hora de início</label>

                        <input type="time"
                               name="hora_inicio"
                               class="form-control"
                               required>

                    </div>

                    <!-- Valor (OBRIGATÓRIO no seu banco) -->
                    <div class="col-md-6 mb-3">

                        <label class="form-label">Valor (R$)</label>

                        <input type="number"
                               step="0.01"
                               name="valor"
                               class="form-control"
                               required>

                    </div>

                    <!-- Observações -->
                    <div class="col-12">

                        <label class="form-label">Observações</label>

                        <textarea name="observacoes"
                                  rows="4"
                                  class="form-control"></textarea>

                    </div>

                </div>

            </div>

        </div>

        <button class="btn btn-primary mt-4">

            <i class="bi bi-calendar-check"></i>
            Salvar Agendamento

        </button>

    </form>

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