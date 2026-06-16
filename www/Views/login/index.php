<div class="container min-vh-100 d-flex align-items-center justify-content-center">

    <div class="card login-card shadow-lg">

        <div class="card-body p-5">

            <div class="text-center mb-4">

                <div class="login-logo mb-3">
                    <i class="bi bi-scissors"></i>
                </div>

                <h2 class="text-white fw-bold">
                    Easy Barber
                </h2>

                <p class="text-secondary mb-0">
                    Acesse sua conta
                </p>

            </div>

            <form action="<?= base_url('login/auth') ?>" method="POST">

                <div class="mb-3">

                    <label for="login" class="form-label text-white">

                        <i class="bi bi-person me-2"></i>
                        E-mail

                    </label>

                    <input
                        type="text"
                        name="login"
                        id="login"
                        class="form-control"
                        placeholder="Digite seu e-mail"
                        required>

                </div>

                <div class="mb-4">

                    <label for="senha" class="form-label text-white">

                        <i class="bi bi-lock me-2"></i>
                        Senha

                    </label>

                    <input
                        type="password"
                        name="senha"
                        id="senha"
                        class="form-control"
                        placeholder="Digite sua senha"
                        required>

                </div>

                <button type="submit" class="btn btn-login w-100">

                    Entrar
                    <i class="bi bi-arrow-right ms-2"></i>

                </button>

            </form>

        </div>

    </div>

</div>