<aside class="sidebar">

    <div class="sidebar-content">

        <!-- Logo -->
        <div class="logo mb-5">
            <i class="bi bi-scissors"></i>
            <span>Easy Barber</span>
        </div>

        <!-- Menu -->
        <ul class="nav flex-column" id="menu-dono">

            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('dono') ?>">
                    <i class="bi bi-speedometer2 mb-1"></i>
                    Dashboard
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('dono/agenda') ?>">
                    <i class="bi bi-calendar3 mb-1"></i>
                    Agenda Geral
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('dono/equipe') ?>">
                    <i class="bi bi-people mb-1"></i>
                    Gerenciar Equipe
                </a>
            </li>

            <li class="nav-item">
                <!-- Mantemos o ícone de tesoura, mas reforçamos o controle de serviços da empresa -->
                <a class="nav-link" href="<?= base_url('dono/servicos') ?>">
                    <i class="bi bi-scissors mb-1"></i>
                    Meus Serviços
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('dono/visagismo') ?>">
                    <i class="bi bi-stars mb-1"></i>
                    Visagismo IA
                </a>
            </li>

            <li class="nav-item">
                <!-- Ícone trocado para um que remete à gestão completa da empresa/estabelecimento -->
                <a class="nav-link" href="<?= base_url('dono/configuracoes') ?>">
                    <i class="bi bi-sliders mb-1"></i>
                    Configurações
                </a>
            </li>

            <li class="nav-item mt-5 border-top border-secondary pt-3">
                <a class="nav-link logout text-danger" href="<?= base_url('login/logout') ?>">
                    <i class="bi bi-box-arrow-right mb-1"></i>
                    Sair do Painel
                </a>
            </li>

        </ul>

    </div>

</aside>

<!-- Script Inteligente para Alternar a Classe Active do Dono Sozinha -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    const urlAtual = window.location.href;
    const linksMenu = document.querySelectorAll('#menu-dono .nav-link');

    linksMenu.forEach(link => {
        // Reseta o estado visual inicial
        link.classList.remove('active');
        
        // Verifica correspondência exata ou sub-rotas (ex: dono/servicos/new ainda acende 'Meus Serviços')
        if (urlAtual === link.href || (urlAtual.includes(link.href) && link.href !== "<?= base_url('dono') ?>")) {
            link.classList.add('active');
        }
    });

    // Fallback de segurança para a rota raiz do painel administrativo
    if (urlAtual === "<?= base_url('dono') ?>/" || urlAtual === "<?= base_url('dono') ?>") {
        linksMenu[0].classList.add('active');
    }
});
</script>