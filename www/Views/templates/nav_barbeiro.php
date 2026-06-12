<aside class="sidebar">

    <div class="sidebar-content">

        <!-- Logo -->
        <div class="logo mb-5">
            <i class="bi bi-scissors"></i>
            <span>Easy Barber</span>
        </div>

        <!-- Menu -->
        <ul class="nav flex-column">

            <li class="nav-item">
                <a class="nav-link active" href="<?= base_url('barbeiro') ?>">
                    <i class="bi bi-grid"></i>
                    Dashboard
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('barbeiro/agenda') ?>">
                    <i class="bi bi-calendar3"></i>
                    Agenda
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('barbeiro/servicos') ?>">
                    <i class="bi bi-scissors"></i>
                    Serviços
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('barbeiro/visagismo') ?>">
                    <i class="bi bi-stars"></i>
                    Visagismo IA
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('barbeiro/configuracoes') ?>">
                    <i class="bi bi-gear"></i>
                    Configurações
                </a>
            </li>

            <li class="nav-item mt-4">
                <a class="nav-link logout" href="<?= base_url('login/logout') ?>">
                    <i class="bi bi-box-arrow-right"></i>
                    Sair
                </a>
            </li>

        </ul>

    </div>

</aside>