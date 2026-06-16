<div class="main-content">
    
    <div class="mb-4">
        <h1 class="text-white mb-1">
            <i class="bi bi-stars text-warning me-2"></i>Visagismo IA
        </h1>
        <p class="text-secondary">
            Analise as proporções faciais do cliente para recomendar o corte e a barba perfeitos.
        </p>
    </div>

    <div class="row g-4">
        
        <div class="col-lg-6">
            <div class="card bg-dark border-secondary h-100">
                <div class="card-body d-flex flex-column justify-content-center align-items-center py-5 text-center">
                    
                    <div class="p-4 bg-black rounded-circle border border-secondary mb-4" style="border-style: dashed !important; width: 100px; height: 100px; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-camera fs-1 text-secondary"></i>
                    </div>

                    <h5 class="text-white mb-2">Enviar Foto do Cliente</h5>
                    <p class="text-muted small px-4 mb-4">
                        Tire uma foto frontal do rosto do cliente ou envie um arquivo (PNG ou JPG) para que a IA faça o mapeamento dos pontos de visagismo.
                    </p>

                    <div class="d-grid gap-2 col-8 mx-auto">
                        <button class="btn btn-primary" onclick="alert('Módulo de câmera em integração...')">
                            <i class="bi bi-webcam me-2"></i>Abrir Câmera
                        </button>
                        <label class="btn btn-outline-secondary border-secondary text-white">
                            <i class="bi bi-upload me-2"></i>Escolher Arquivo
                            <input type="file" accept="image/*" class="d-none">
                        </label>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card bg-dark border-secondary h-100">
                <div class="card-body">
                    <h5 class="text-white mb-4">
                        <i class="bi bi-cpu text-info me-2"></i>O que a IA analisa?
                    </h5>

                    <div class="d-flex align-items-start mb-3">
                        <div class="badge bg-black border border-secondary p-2 me-3 text-info">
                            <i class="bi bi-hexagon fs-5"></i>
                        </div>
                        <div>
                            <h6 class="text-white mb-1">Formato do Rosto</h6>
                            <p class="text-secondary small mb-0">Identifica se o formato é oval, redondo, quadrado, retangular ou triangular.</p>
                        </div>
                    </div>

                    <div class="d-flex align-items-start mb-3">
                        <div class="badge bg-black border border-secondary p-2 me-3 text-warning">
                            <i class="bi bi-symmetry-horizontal fs-5"></i>
                        </div>
                        <div>
                            <h6 class="text-white mb-1">Linhas de Simetria</h6>
                            <p class="text-secondary small mb-0">Mapeia a distância entre olhos, maçãs do rosto e maxilar para equilibrar os volumes do cabelo.</p>
                        </div>
                    </div>

                    <div class="d-flex align-items-start">
                        <div class="badge bg-black border border-secondary p-2 me-3 text-success">
                            <i class="bi bi-patch-check fs-5"></i>
                        </div>
                        <div>
                            <h6 class="text-white mb-1">Harmonização de Barba</h6>
                            <p class="text-secondary small mb-0">Sugere desenhos de barba (como espartana, lenhador ou cavanhaque) que preenchem e valorizam o queixo.</p>
                        </div>
                    </div>

                    <div class="mt-4 p-3 bg-black rounded border border-warning border-opacity-25 text-center">
                        <span class="text-warning small d-block">
                            <i class="bi bi-exclamation-triangle me-1"></i> 
                            Dica: Para melhores resultados, certifique-se de que o cliente esteja em um local bem iluminado e sem óculos.
                        </span>
                    </div>

                </div>
            </div>
        </div>

    </div>

</div>