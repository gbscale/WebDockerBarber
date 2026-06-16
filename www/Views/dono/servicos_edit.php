<?php 
if(isset($_SESSION['usuario_logado'])){
    if($_SESSION['usuario_logado']->cargo == 'dono'){
?>

<div class="main-content">

    <h1 class="mb-4 text-white">
        Editar Serviço
    </h1>

    <form
       
        method="POST"
        action="<?= base_url('dono/servicos/update?id=' . $servico->id) ?>">

        <div class="card">

            <div class="card-body">

                <div class="mb-3">

                    <label>
                        Nome
                    </label>

                    <input
                        type="text"
                        name="nome"
                        value="<?= htmlspecialchars($servico->nome) ?>"
                        class="form-control"
                        required>

                </div>

                <div class="mb-3">

                    <label>
                        Descrição
                    </label>

                    <textarea
                        name="descricao"
                        class="form-control"><?= htmlspecialchars($servico->descricao) ?></textarea>

                </div>

                <div class="row">

                    <div class="col-md-6">

                        <label>
                            Duração (minutos)
                        </label>

                        <input
                            type="number"
                            name="duracao"
                            value="<?= $servico->duracao ?>"
                            class="form-control">

                    </div>

                    <div class="col-md-6">

                        <label>
                            Preço
                        </label>

                        <input
                            type="text"
                            name="valor"
                            value="<?= str_replace('.', ',', $servico->valor) ?>"
                            class="form-control">

                    </div>

                </div>

            </div>

        </div>

        <button
            class="btn btn-primary mt-3">

            Atualizar Serviço

        </button>
        
        <a href="<?= base_url('dono/servicos') ?>" class="btn btn-secondary mt-3 ms-2">
            Cancelar
        </a>

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
?>