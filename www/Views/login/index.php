<div class="container p-5">
    <div class="row mt-5">
        <div class="mx-auto border border-3 border-danger rounded p-5 bg-dark text-white">
                
                <h2 class="p-3">Acesso ao Sistema</h2>

                <form action="<?php echo base_url("login/auth") ?>" method="POST">
                    <div class="mb-3">
                        <label for="login">
                            <i class="bi bi-person"></i>
                            Login
                        </label>
                        <input type="text" name="login" class="form-control" id="login">
                    </div>

                    <div class="mb-3">
                        <label for="senha">
                            <i class="bi bi-lock"></i>
                            Senha
                        </label>
                        <input type="password" name="senha" class="form-control" id="senha">
                    </div>

                    <p class="text-center">
                        <button type="submit" class="btn btn-lg btn-primary">
                            Acessar
                            <i class="bi bi-box-arrow-in-right"></i>
                        </button>
                    </p>

                </form>

            </div>

        </div>
    </div>
</div>