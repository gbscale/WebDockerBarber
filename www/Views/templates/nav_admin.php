<aside class="sidebar">

    <div class="sidebar-content">

        <div class="logo">
            <img src="<?= base_url('public/assets/images/logo_bargain2.png') ?>"
                 alt="Bargain"
                 width="130">
        </div>

        <ul class="nav flex-column mt-4">

            <li class="nav-item">
                <a class="nav-link active" href="<?= base_url('admin') ?>">
                    <i class="bi bi-house-fill"></i>
                    Home Admin
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('admin/barbearias') ?>">
                    <i class="bi bi-shop"></i>
                    Barbearias
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('categorias') ?>">
                    <i class="bi bi-shield-lock"></i>
                    Auth
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('usuarios') ?>">
                    <i class="bi bi-people-fill"></i>
                    Usuários
                </a>
            </li>

            <li class="nav-item mt-4">
                <a class="nav-link logout"
                   href="<?= base_url('login/logout') ?>">
                    <i class="bi bi-box-arrow-right"></i>
                    Sair
                </a>
            </li>

        </ul>

    </div>

</aside>