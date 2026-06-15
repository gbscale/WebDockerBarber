<?php 
if(isset($_SESSION['usuario_logado'])){
    if($_SESSION['usuario_logado']->cargo == 'barbeiro'){
?>

<div class="main-content">

    <div class="mb-4">

        <h1 class="text-white mb-1">
            Configurações
        </h1>

        <p class="text-secondary">
            Gerencie suas informações pessoais.
        </p>

    </div>

    <div class="card">

        <div class="card-body">

            <form method="POST" action="<?= base_url('barbeiro/configuracoes/save') ?>">

                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label text-white">Nome</label>

                        <input
                            type="text"
                            name="nome"
                            class="form-control"
                            value="<?= $usuario->nome ?>"
                            required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label text-white">E-mail</label>

                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            value="<?= $usuario->email ?>"
                            required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label text-white">Telefone</label>

                        <input
                            type="text"
                            name="telefone"
                            class="form-control"
                            value="<?= $usuario->telefone ?>">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label text-white">
                            Atende Clientes
                        </label>

                        <select name="atende_clientes" class="form-select">

                            <option value="1" <?= $usuario->atende_clientes ? 'selected' : '' ?>>
                                Sim
                            </option>

                            <option value="0" <?= !$usuario->atende_clientes ? 'selected' : '' ?>>
                                Não
                            </option>

                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label text-white">
                            Agenda Ativa
                        </label>

                        <select name="agenda_ativa" class="form-select">

                            <option value="1" <?= $usuario->agenda_ativa ? 'selected' : '' ?>>
                                Sim
                            </option>

                            <option value="0" <?= !$usuario->agenda_ativa ? 'selected' : '' ?>>
                                Não
                            </option>

                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label text-white">
                            Nova Senha
                        </label>

                        <input
                            type="password"
                            name="senha"
                            class="form-control"
                            placeholder="Deixe em branco para não alterar">
                    </div>

                </div>

                <div class="mt-4">

                    <button type="submit" class="btn btn-primary">

                        <i class="bi bi-check-lg"></i>
                        Salvar Alterações

                    </button>

                </div>

            </form>

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