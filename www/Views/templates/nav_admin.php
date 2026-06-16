<aside class="sidebar">

    <div class="sidebar-content">

        <!-- Logo Centralizada do SaaS -->
        <div class="logo mb-4 text-center">
            <img src="<?= base_url('public/assets/images/easy.png') ?>" alt="Easy Barber" width="140" class="bg-transparent img-fluid" style="background: transparent !important;">
            <span class="badge bg-danger text-uppercase d-block mt-2 mx-auto border border-dark" style="max-width: 120px; font-size: 10px; letter-spacing: 1px;">
                Admin
            </span>
        </div>

        <!-- Menu Superior Core -->
        <ul class="nav flex-column" id="menu-master-admin">

            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('admin') ?>">
                    <i class="bi bi-shield-shaded mb-1 text-danger"></i>
                    Painel Geral
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('admin/barbearias') ?>">
                    <i class="bi bi-shop mb-1"></i>
                    Barbearias (Tenants)
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('admin/usuarios') ?>">
                    <i class="bi bi-people-fill mb-1"></i>
                    Controle de Usuários
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('admin/planos') ?>">
                    <i class="bi bi-card-checklist mb-1"></i>
                    Planos & Assinaturas
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('admin/financeiro') ?>">
                    <i class="bi bi-currency-dollar mb-1 text-success"></i>
                    Faturamento Global
                </a>
            </li>

            <!-- Linha divisória para deslogar com segurança -->
            <li class="nav-item mt-5 border-top border-secondary pt-3">
                <a class="nav-link logout text-opacity-75 text-white" href="<?= base_url('login/logout') ?>">
                    <i class="bi bi-power mb-1 text-danger"></i>
                    Encerrar Sessão
                </a>
            </li>

        </ul>

    </div>

</aside>

<!-- Script de Destaque Automático de Menu Ativo (Otimizado) -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    // 🌟 Melhoria 1: Removemos query strings ou hashes (como ?id=1 ou #topo) para a comparação ser exata
    const urlAtual = window.location.href.split('?')[0].split('#')[0].replace(/\/$/, ""); 
    const linksMenu = document.querySelectorAll('#menu-master-admin .nav-link');
    const urlBaseAdmin = "<?= base_url('admin') ?>".replace(/\/$/, "");

    let algunLinkAtivado = false;

    linksMenu.forEach(link => {
        link.classList.remove('active');
        const hrefLink = link.href.replace(/\/$/, "");
        
        // Evita marcar a home por engano quando estiver em sub-rotas
        if (hrefLink !== urlBaseAdmin && urlAtual.startsWith(hrefLink)) {
            link.classList.add('active');
            algunLinkAtivado = true;
        }
    });

    // 🌟 Melhoria 2: Se nenhuma sub-rota foi ativada e estamos na raiz do admin, acende o Painel Geral
    if (!algunLinkAtivado && (urlAtual === urlBaseAdmin || urlAtual === urlBaseAdmin + '/index.php')) {
        if(linksMenu[0]) linksMenu[0].classList.add('active');
    }
});
</script>