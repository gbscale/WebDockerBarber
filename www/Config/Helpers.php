<?php

function accessNavigate(){

    if(!isset($_SESSION['usuario_logado'])){

        include('Views/templates/nav.php');
        return;
    }

    $cargo = $_SESSION['usuario_logado']->cargo ?? '';

    switch($cargo){

        case 'admin':
            include('Views/templates/nav_admin.php');
            break;

        case 'dono':
            include('Views/templates/nav_dono.php');
            break;

        case 'barbeiro':
            include('Views/templates/nav_barbeiro.php');
            break;

        default:
            include('Views/templates/nav.php');
            break;
    }
}

function view($viewName, $data = [])
{
    $viewPath = "Views/{$viewName}.php";

    if (file_exists($viewPath)) {
        // Extrai as variáveis do array $data para dentro da view
        extract($data);
        include $viewPath;
    } else {
        echo "Página não encontrada!";
    }
}

function base_url($path = '') {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
    $host = $_SERVER['HTTP_HOST'];
    $scriptName = dirname($_SERVER['SCRIPT_NAME']);
    $url = rtrim($protocol . "://" . $host . $scriptName, '/');

    return $url . '/' . ltrim($path, '/');
}

function msg($texto, $tipo = 'success'){
    $alertType = "alert-{$tipo}";
    if($tipo == 'danger'){
        $icone = '<i class="bi bi-exclamation-triangle-fill"></i>';
    }
    else{
        $icone = '<i class="bi bi-check-circle-fill"></i>';
    }
    
    return '
        <div class="alert '.$alertType.'" role="alert">
        '.$icone.' '.$texto.' 
        </div>
        ';
}

function flash(string $texto, string $color = 'success'): array{
        return [
            'texto' => $texto,
            'color' => $color
        ];
    }

function redirectPage($path, $message = null) {
        if ($message) {
            $_SESSION['msg'] = $message;
        }
        header("Location: {$path}");
        exit;
    }

?>