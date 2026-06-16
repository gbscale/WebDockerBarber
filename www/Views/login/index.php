<div class="container min-vh-100 d-flex align-items-center justify-content-center">

    <div class="card bg-dark border-secondary shadow-lg login-card" style="max-width: 450px; width: 100%;">

        <div class="card-body p-5">

            <div class="text-center mb-4">

                <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3 login-logo" style="width: 60px; height: 60px;">
                    <i class="bi bi-scissors fs-3"></i>
                </div>

                <h2 class="text-white fw-bold mb-1">Easy Barber</h2>
                <p class="text-secondary small mb-0">Acesse sua conta</p>

            </div>

            <form action="<?= base_url('login/auth') ?>" method="POST">

                <div class="mb-3">
                    <label for="login" class="form-label text-white small fw-bold">
                        <i class="bi bi-person me-2"></i>E-mail
                    </label>
                    <input
                        type="text"
                        name="login"
                        id="login"
                        class="form-control bg-black text-white border-secondary py-2"
                        placeholder="Digite seu e-mail"
                        required>
                </div>

                <div class="mb-4">
                    <label for="senha" class="form-label text-white small fw-bold">
                        <i class="bi bi-lock me-2"></i>Senha
                    </label>
                    <input
                        type="password"
                        name="senha"
                        id="senha"
                        class="form-control bg-black text-white border-secondary py-2"
                        placeholder="Digite sua senha"
                        required>
                </div>

                <button type="submit" class="btn btn-danger btn-login w-100 fw-bold py-2 shadow">
                    Entrar
                    <i class="bi bi-arrow-right ms-2"></i>
                </button>

            </form>

        </div>

    </div>

</div>