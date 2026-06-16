<aside class="sidebar">

    <div class="sidebar-content">

        <!-- Logo -->
        <div class="logo mb-5">
            <i class="bi bi-scissors"></i>
            <span>Easy Barber</span>
        </div>

        <!-- Menu -->
        <ul class="nav flex-column" id="menu-barbeiro">

            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('barbeiro') ?>">
                    <i class="bi bi-grid mb-1"></i>
                    Dashboard
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('barbeiro/agenda') ?>">
                    <i class="bi bi-calendar3 mb-1"></i>
                    Minha Agenda
                </a>
            </li>

            <li class="nav-item">
                <!-- Mudamos o ícone para uma tabela/lista e o texto para refletir que é apenas consulta -->
                <a class="nav-link" href="<?= base_url('barbeiro/servicos') ?>">
                    <i class="bi bi-journal-text mb-1"></i>
                    Tabela de Preços
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('barbeiro/visagismo') ?>">
                    <i class="bi bi-stars mb-1"></i>
                    Visagismo IA
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('barbeiro/configuracoes') ?>">
                    <i class="bi bi-person-gear mb-1"></i>
                    Meu Perfil
                </a>
            </li>

            <li class="nav-item mt-5 border-top border-secondary pt-3">
                <a class="nav-link logout text-danger" href="<?= base_url('login/logout') ?>">
                    <i class="bi bi-box-arrow-right mb-1"></i>
                    Sair da Conta
                </a>
            </li>

        </ul>

    </div>

</aside>

<!-- Script Inteligente para Alternar a Classe Active Sozinha -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    const urlAtual = window.location.href;
    const linksMenu = document.querySelectorAll('#menu-barbeiro .nav-link');

    linksMenu.forEach(link => {
        // Remove a classe active padrão de todos primeiro
        link.classList.remove('active');
        
        // Se a URL atual contiver o link do menu, ele ganha o destaque visual
        if (urlAtual === link.href || (urlAtual.includes(link.href) && link.href !== "<?= base_url('barbeiro') ?>")) {
            link.classList.add('active');
        }
    });

    // Fallback: Se estiver exatamente na raiz do barbeiro, força o primeiro como active
    if (urlAtual === "<?= base_url('barbeiro') ?>/" || urlAtual === "<?= base_url('barbeiro') ?>") {
        linksMenu[0].classList.add('active');
    }
});
</script>