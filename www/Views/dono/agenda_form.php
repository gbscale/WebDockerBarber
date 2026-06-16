<?php 
if(isset($_SESSION['usuario_logado']) && $_SESSION['usuario_logado']->cargo == 'dono'){
?>

<div class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="text-white">Novo Agendamento</h1>
            <p class="text-secondary">Selecione o profissional, a data e escolha um horário livre.</p>
        </div>
        <a href="<?= base_url('dono/agenda') ?>" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Voltar
        </a>
    </div>

    <?php if (isset($_SESSION['msg'])): ?>
        <div class="alert alert-<?= $_SESSION['msg']['color'] ?> mb-3">
            <?= $_SESSION['msg']['texto'] ?>
        </div>
        <?php unset($_SESSION['msg']); ?>
    <?php endif; ?>

    <form method="POST" action="<?= base_url('dono/agenda/save') ?>">
        <div class="row">
            
            <!-- Coluna de Dados Cadastrais -->
            <div class="col-lg-7 mb-4">
                <div class="card bg-dark border-secondary h-100">
                    <div class="card-body">
                        <h5 class="text-white mb-3">Informações do Atendimento</h5>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-white">Cliente</label>
                                <input type="text" name="cliente_nome" class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label text-white">Telefone</label>
                                <input type="text" name="cliente_telefone" class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label text-white">Serviço</label>
                                <select name="servico_id" class="form-select" required>
                                    <option value="">Selecione o Serviço</option>
                                    <?php foreach($servicos as $servico): ?>
                                        <option value="<?= $servico->id ?>">
                                            <?= $servico->nome ?> - R$ <?= number_format($servico->valor, 2, ',', '.') ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label text-white">Barbeiro</label>
                                <select name="barbeiro_id" id="filtro_barbeiro" class="form-select" required>
                                    <option value="">Selecione o Barbeiro</option>
                                    <?php foreach($barbeiros as $b): ?>
                                        <option value="<?= $b->id ?>" <?= $barbeiro_selecionado == $b->id ? 'selected' : '' ?>>
                                            <?= $b->nome ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label text-white">Data do Agendamento</label>
                                <input type="date" name="data_agendamento" id="filtro_data" value="<?= $data_selecionada ?>" class="form-control" required>
                            </div>

                            <div class="col-12">
                                <label class="form-label text-white">Observações</label>
                                <textarea name="observacoes" rows="3" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Coluna de Horários Disponíveis -->
            <div class="col-lg-5 mb-4">
                <div class="card bg-dark border-secondary h-100">
                    <div class="card-body">
                        <h5 class="text-white mb-3">Horários Disponíveis para este dia</h5>
                        
                        <!-- Input oculto que armazena a hora que o dono clicar -->
                        <input type="hidden" name="hora_inicio" id="hora_final_input" required>

                        <?php if (empty($barbeiro_selecionado) || empty($data_selecionada)): ?>
                            <div class="text-center py-4 text-muted">
                                <i class="bi bi-info-circle fs-3 d-block mb-2"></i>
                                Selecione um Barbeiro e uma Data para checar a grade.
                            </div>
                        <?php elseif (empty($horarios_disponiveis)): ?>
                            <div class="text-center py-4 text-danger">
                                <i class="bi bi-calendar-x fs-3 d-block mb-2"></i>
                                Agenda cheia ou indisponível para este dia!
                            </div>
                        <?php else: ?>
                            <div class="row g-2" style="max-height: 320px; overflow-y: auto;">
                                <?php foreach ($horarios_disponiveis as $hora): ?>
                                    <div class="col-4">
                                        <!-- O type="button" explícito impede o envio involuntário do formulário -->
                                        <button type="button" 
                                                class="btn btn-outline-light w-100 btn-slot-hora py-2" 
                                                data-hora="<?= $hora ?>">
                                            <?= $hora ?>
                                        </button>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary btn-lg mt-2 w-100">
            <i class="bi bi-calendar-check"></i> Concluir Agendamento
        </button>
    </form>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const filtroBarbeiro = document.getElementById('filtro_barbeiro');
    const filtroData = document.getElementById('filtro_data');
    const inputHora = document.getElementById('hora_final_input');
    const botoesHora = document.querySelectorAll('.btn-slot-hora');

    function recarregarGradeHorarios() {
        // Só recarrega se ambos os campos estiverem preenchidos e válidos
        if(filtroBarbeiro.value && filtroData.value && filtroData.value.length === 10) {
            window.location.href = `<?= base_url('dono/agenda/new') ?>?barbeiro_id=${filtroBarbeiro.value}&data=${filtroData.value}`;
        }
    }

    // Dispara ao mudar o barbeiro
    filtroBarbeiro.addEventListener('change', recarregarGradeHorarios);
    
    // O evento 'blur' aguarda você terminar de digitar/escolher a data e clicar fora ou mudar de campo
    filtroData.addEventListener('blur', recarregarGradeHorarios);

    // Gerencia o clique visual nos cards de horário
    botoesHora.forEach(botao => {
        botao.addEventListener('click', function() {
            // Reseta a cor de todos os botões de horário
            botoesHora.forEach(b => b.classList.replace('btn-primary', 'btn-outline-light'));
            // Destaca o botão que acabou de ser clicado
            this.classList.replace('btn-outline-light', 'btn-primary');
            // Alimenta o nosso input hidden com o valor correto
            inputHora.value = this.getAttribute('data-hora');
        });
    });
});
</script>

<?php
} else {
    redirectPage(base_url('login'));
}
?>