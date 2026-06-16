<div class="main-content">
    
    <div class="mb-4">
        <h1 class="text-white mb-1">
            <i class="bi bi-stars text-warning me-2"></i>Visagismo IA Local
        </h1>
        <p class="text-secondary">
            Mapeamento de proporções carregado instantaneamente dos arquivos locais do sistema.
        </p>
    </div>

    <div id="model-status" class="alert alert-info bg-dark text-info border-info border-opacity-25 mb-4 text-center">
        <div class="spinner-border spinner-border-sm me-2" role="status"></div>
        <span>Carregando inteligência artificial dos arquivos locais...</span>
    </div>

    <div class="row g-4">
        
        <div class="col-lg-6">
            <div class="card bg-dark border-secondary h-100">
                <div class="card-body d-flex flex-column justify-content-center align-items-center py-5 text-center">
                    
                    <div id="upload-icon-container" class="p-4 bg-black rounded-circle border border-secondary mb-4" style="border-style: dashed !important; width: 100px; height: 100px; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-camera fs-1 text-secondary"></i>
                    </div>

                    <img id="image-preview" class="img-fluid rounded border border-secondary mb-4 d-none" style="max-height: 250px; object-fit: cover;" src="" alt="Preview">

                    <h5 class="text-white mb-2">Selecione a Foto do Cliente</h5>
                    <p class="text-muted small px-4 mb-4">
                        O processamento roda 100% offline utilizando o hardware deste dispositivo.
                    </p>

                    <div class="d-grid gap-2 col-10 mx-auto">
                        <label class="btn btn-primary disabled" id="btn-upload-label">
                            <i class="bi bi-upload me-2"></i>Escolher Foto
                            <input type="file" id="foto_cliente" accept="image/*" class="d-none" onchange="processarVisagismoReal(this)" disabled>
                        </label>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-lg-6" id="container-resultado">
            <div class="card bg-dark border-secondary h-100">
                <div class="card-body d-flex flex-column justify-content-center align-items-center text-center p-5">
                    <i class="bi bi-cpu text-secondary fs-1 mb-3"></i>
                    <h5 class="text-white">Aguardando Processamento</h5>
                    <p class="text-secondary small mb-0">Insira uma foto para iniciar o mapeamento dos pontos.</p>
                </div>
            </div>
        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/@vladmandic/face-api/dist/face-api.js"></script>

<script>
const PASTA_MODELOS = '<?= base_url("public/models") ?>';

async function carregarModelosIA() {
    try {
        // Carrega os arquivos locais da sua pasta www/public/models
        await faceapi.nets.ssdMobilenetv1.loadFromUri(PASTA_MODELOS);
        await faceapi.nets.faceLandmark68Net.loadFromUri(PASTA_MODELOS);
        
        document.getElementById('model-status').className = "alert alert-success bg-dark text-success border-success border-opacity-25 mb-4 text-center";
        document.getElementById('model-status').innerHTML = '<i class="bi bi-shield-check-fill me-2"></i>IA Local Pronta (Carregamento Instantâneo)!';
        document.getElementById('btn-upload-label').classList.remove('disabled');
        document.getElementById('foto_cliente').removeAttribute('disabled');
    } catch (error) {
        console.error("Erro ao carregar os modelos locais:", error);
        document.getElementById('model-status').className = "alert alert-danger bg-dark text-danger border-danger border-opacity-25 mb-4 text-center";
        document.getElementById('model-status').innerText = "Erro: Certifique-se de que os arquivos do modelo estão na pasta public/models/.";
    }
}

window.addEventListener('DOMContentLoaded', carregarModelosIA);

async function processarVisagismoReal(input) {
    if (!input.files || !input.files[0]) return;

    const imgPreview = document.getElementById('image-preview');
    document.getElementById('upload-icon-container').classList.add('d-none');
    imgPreview.classList.remove('d-none');
    imgPreview.src = URL.createObjectURL(input.files[0]);

    document.getElementById('container-resultado').innerHTML = `
        <div class="card-body d-flex flex-column justify-content-center align-items-center text-center p-5">
            <div class="spinner-border text-warning mb-3" role="status"></div>
            <h5 class="text-white">IA Analisando Localmente...</h5>
            <p class="text-warning small mb-0">Processando matriz de pixels via hardware.</p>
        </div>
    `;

    imgPreview.onload = async () => {
        const analise = await faceapi.detectSingleFace(imgPreview).withFaceLandmarks();

        if (!analise) {
            document.getElementById('container-resultado').innerHTML = `
                <div class="card-body d-flex flex-column justify-content-center align-items-center text-center p-5 border border-danger rounded">
                    <i class="bi bi-exclamation-circle text-danger fs-1 mb-2"></i>
                    <h5 class="text-white">Rosto não detectado</h5>
                    <p class="text-secondary small mb-0">Use uma foto nítida, de frente e sem óculos.</p>
                </div>
            `;
            return;
        }

        const pontosFaciais = analise.landmarks.getJawOutline();
        
        const larguraMaxilar = Math.abs(pontosFaciais[0].x - pontosFaciais[16].x);
        const alturaRosto = Math.abs(pontosFaciais[8].y - ((pontosFaciais[0].y + pontosFaciais[16].y) / 2));
        const razaoProporcao = alturaRosto / larguraMaxilar;
        
        let formatoDetectado = 'Oval'; 

        if (razaoProporcao > 1.35) {
            formatoDetectado = 'Retangular';
        } else if (razaoProporcao < 1.1) {
            formatoDetectado = 'Redondo';
        } else {
            const curvaturaQueixo = Math.abs(pontosFaciais[6].y - pontosFaciais[8].y);
            formatoDetectado = (curvaturaQueixo > 18) ? 'Quadrado' : 'Oval';
        }

        enviarAoPHP(formatoDetectado);
    };
}

function enviarAoPHP(formato) {
    const formData = new FormData();
    formData.append('formato_rosto', formato);

    fetch('<?= base_url("barbeiro/visagismo_analisar") ?>', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById('container-resultado').innerHTML = `
            <div class="card bg-dark border-success h-100">
                <div class="card-body">
                    <span class="badge bg-success-subtle text-success border border-success mb-2 px-2 py-1 text-uppercase small">Mapeamento Concluído</span>
                    <h5 class="text-white mb-4"><i class="bi bi-cpu text-success me-2"></i>Resultado do Visagismo</h5>
                    
                    <div class="p-3 bg-black rounded border border-secondary mb-3">
                        <span class="text-muted small d-block">Estrutura Óssea Identificada</span>
                        <strong class="text-warning fs-5">${data.formato_rosto}</strong>
                    </div>

                    <div class="mb-3">
                        <h6 class="text-white mb-1"><i class="bi bi-scissors text-danger me-2"></i>Sugestão de Corte:</h6>
                        <p class="text-secondary small bg-black p-2 rounded border border-secondary">${data.corte_recomendado}</p>
                    </div>

                    <div class="mb-3">
                        <h6 class="text-white mb-1"><i class="bi bi-droplet text-info me-2"></i>Desenho da Barba:</h6>
                        <p class="text-secondary small bg-black p-2 rounded border border-secondary">${data.barba_recomendada}</p>
                    </div>
                </div>
            </div>
        `;
    })
    .catch(error => {
        console.error("Erro na requisição AJAX:", error);
    });
}
</script>