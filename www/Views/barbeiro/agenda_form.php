<div class="main-content">
    <div class="mb-4">
        <h1 class="text-white">Novo Agendamento</h1>
        <p class="text-secondary">Insira os dados do cliente para reservar um horário na sua lista.</p>
    </div>

    <div class="card bg-dark border-secondary text-white">
        <div class="card-body">
            <form method="POST" action="<?= base_url('barbeiro/agenda/save') ?>">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nome do Cliente</label>
                        <input type="text" name="cliente_nome" class="form-control bg-black text-white border-secondary" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Telefone do Cliente</label>
                        <input type="text" name="cliente_telefone" class="form-control bg-black text-white border-secondary" placeholder="(00) 00000-0000" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Escolha o Serviço</label>
                        <select name="servico_id" class="form-select bg-black text-white border-secondary" required>
                            <option value="">Selecione...</option>
                            <?php foreach ($servicos as $s): ?>
                                <option value="<?= $s->id ?>"><?= $s->nome ?> (R$ <?= number_format($s->preco, 2, ',', '.') ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Data</label>
                        <input type="date" name="data_agendamento" class="form-control bg-black text-white border-secondary" value="<?= date('Y-m-d') ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Horário de Início</label>
                        <input type="time" name="hora_inicio" class="form-control bg-black text-white border-secondary" required>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Observações</label>
                        <textarea name="observacoes" class="form-control bg-black text-white border-secondary" rows="3"></textarea>
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Agendar Horário</button>
                    <a href="<?= base_url('barbeiro/agenda') ?>" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>