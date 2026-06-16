<!-- Cabeçalho de Contato -->
<header class="contact-hero py-5 text-center text-white" style="background: linear-gradient(135deg, #111 0%, #1a1a1a 100%); border-bottom: 1px solid #333;">
    <div class="container py-4">
        <span class="badge bg-danger px-3 py-2 text-uppercase mb-2 shadow">FALE CONOSCO</span>
        <h1 class="display-4 fw-bold">Leve sua Barbearia para o próximo nível</h1>
        <p class="lead text-secondary mx-auto" style="max-width: 600px;">
            Tem dúvidas sobre os planos, precisa de suporte ou quer uma demonstração personalizada? Fale com nosso time de especialistas.
        </p>
    </div>
</header>

<section class="contact-section py-5 bg-black text-white">
    <div class="container">

        <div class="row g-4 justify-content-center">

            <!-- Coluna de Informações de Contato -->
            <div class="col-lg-4">
                <div class="contact-card p-4 bg-dark rounded border border-secondary h-100">
                    <h3 class="fw-bold mb-4 text-white">Canais de Atendimento</h3>

                    <div class="d-flex align-items-start mb-4">
                        <div class="bg-danger-subtle text-danger rounded p-2 me-3">
                            <i class="bi bi-geo-alt-fill fs-4"></i>
                        </div>
                        <div>
                            <strong class="text-white d-block mb-1">Localização</strong>
                            <p class="text-secondary mb-0">Ceres - GO</p>
                        </div>
                    </div>

                    <div class="d-flex align-items-start mb-4">
                        <div class="bg-danger-subtle text-danger rounded p-2 me-3">
                            <i class="bi bi-telephone-fill fs-4"></i>
                        </div>
                        <div>
                            <strong class="text-white d-block mb-1">Telefone Comercial</strong>
                            <p class="text-secondary mb-0">(62) 99999-9999</p>
                        </div>
                    </div>

                    <div class="d-flex align-items-start mb-4">
                        <div class="bg-danger-subtle text-danger rounded p-2 me-3">
                            <i class="bi bi-envelope-fill fs-4"></i>
                        </div>
                        <div>
                            <strong class="text-white d-block mb-1">E-mail Corporativo</strong>
                            <p class="text-secondary mb-0">contato@easybarber.com.br</p>
                        </div>
                    </div>

                    <div class="d-flex align-items-start">
                        <div class="bg-danger-subtle text-danger rounded p-2 me-3">
                            <i class="bi bi-clock-fill fs-4"></i>
                        </div>
                        <div>
                            <strong class="text-white d-block mb-1">Horário de Suporte</strong>
                            <p class="text-secondary mb-0">Segunda a Sábado • 09h às 20h</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Coluna do Formulário -->
            <div class="col-lg-7">
                <div class="contact-card p-4 bg-dark rounded border border-secondary">
                    <h3 class="fw-bold mb-4 text-white">Envie uma mensagem</h3>

                    <form action="" method="POST" onsubmit="alert('Mensagem enviada com sucesso! Nossa equipe entrará em contato.'); return true;">
                        
                        <div class="mb-3">
                            <label class="text-secondary small fw-bold mb-2">Seu Nome</label>
                            <input type="text" class="form-control bg-black text-white border-secondary" id="nome" placeholder="Digite seu nome completo" required>
                        </div>

                        <div class="mb-3">
                            <label class="text-secondary small fw-bold mb-2">Seu E-mail</label>
                            <input type="email" class="form-control bg-black text-white border-secondary" id="email" placeholder="seu@email.com" required>
                        </div>

                        <div class="mb-3">
                            <label class="text-secondary small fw-bold mb-2">Mensagem / Dúvida</label>
                            <textarea class="form-control bg-black text-white border-secondary" id="mensagem" rows="5" placeholder="Escreva detalhadamente como podemos te ajudar..." required></textarea>
                        </div>

                        <div class="form-check mb-4">
                            <input class="form-check-input bg-black border-secondary" type="checkbox" id="politicaPrivacidade" required>
                            <label class="form-check-label text-secondary small" for="politicaPrivacidade">
                                Aceito os termos de uso e políticas de privacidade do Easy Barber.
                            </label>
                        </div>

                        <button type="submit" class="btn btn-danger fw-bold px-4 py-2 shadow">
                            <i class="bi bi-send-fill me-2"></i>
                            Enviar Mensagem
                        </button>

                    </form>
                </div>
            </div>

        </div>

    </div>
</section>