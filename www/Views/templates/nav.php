<!-- Abre o menu de navegação -->
<nav class="navbar navbar-expand-lg" data-bs-theme="dark">

    <div class="container">

        <!-- Botão Mobile -->
        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent"
            aria-expanded="false"
            aria-label="Toggle navigation">

            <span class="navbar-toggler-icon"></span>

        </button>

        <!-- Menu -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <ul class="navbar-nav mx-auto mb-2 mb-lg-0">

                <!-- Início -->
                <li class="nav-item">
                    <a
                        class="nav-link active"
                        aria-current="page"
                        href="<?= base_url('login/logout') ?>">

                        <i class="bi bi-house-fill"></i>
                        Início

                    </a>
                </li>

                <!-- Recursos -->
                <li class="nav-item">
                    <a
                        class="nav-link"
                        href="<?= base_url('home/recursos') ?>">

                        <i class="bi bi-grid"></i>
                        Recursos

                    </a>
                </li>

                <!-- Planos -->
                <li class="nav-item">
                    <a
                        class="nav-link"
                        href="<?= base_url('home/planos') ?>">

                        <i class="bi bi-cash-stack"></i>
                        Planos

                    </a>
                </li>

                <!-- Contato -->
                <li class="nav-item">
                    <a
                        class="nav-link"
                        href="<?= base_url('home/contato') ?>">

                        <i class="bi bi-telephone-fill"></i>
                        Contato

                    </a>
                </li>

            </ul>

        </div>

    </div>

</nav>
<!-- Fecha o menu de navegação -->