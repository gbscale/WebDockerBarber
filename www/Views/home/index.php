<section class="hero d-flex align-items-center justify-content-center text-center text-white" style="background: linear-gradient(rgba(0,0,0,0.75), rgba(0,0,0,0.85)), url('https://images.unsplash.com/photo-1503951914875-452162b0f3f1?q=80&w=1470') center/cover no-repeat; min-height: 80vh;">

    <div class="container py-5">
        <span class="badge bg-danger px-3 py-2 text-uppercase mb-3 shadow">GESTÃO DE BARBEARIAS</span>
        <h1 class="display-3 fw-bold mb-3 text-white">Seu estilo começa aqui.</h1>
        <p class="lead text-secondary-50 mx-auto mb-4" style="max-width: 600px;">
            Controle agendamentos, organize barbeiros parceiros e turbine o faturamento da sua empresa em uma única plataforma online.
        </p>

        <div class="d-flex gap-3 justify-content-center">
            <a href="<?= base_url('usuarios/new') ?>" class="btn btn-danger btn-lg px-4 fw-bold shadow">
                <i class="bi bi-plus-circle me-1"></i>Criar Conta
            </a>
            <a href="<?= base_url('login') ?>" class="btn btn-outline-light btn-lg px-4">
                Fazer Login <i class="bi bi-box-arrow-in-right ms-1"></i>
            </a>
        </div>
    </div>

</section>