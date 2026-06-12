<?php

ob_start();
session_start();

$nivel = null;

if (isset($_SESSION['usuario_logado'])) {

    $usuario = $_SESSION['usuario_logado'];

    if (is_object($usuario) && isset($usuario->cargo)) {
        $nivel = $usuario->cargo;
    }

}


include_once 'Config/Helpers.php';
include_once 'Autoloader.php';
include('Views/templates/header.php');
echo accessNavigate($nivel);

// Carrega as rotas
$routes = require __DIR__ . '/Config/Routes.php';

// Pega URI atual
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = rtrim($uri, '/') ?: '/';


// Função para fazer match de rota com parâmetro
function matchRoute($uri, $routes)
{
    foreach ($routes as $route => $handler) {
        // Converte rota para regex (ex: /user/{id} → \/user\/([^\/]+))
        $pattern = preg_replace('/\{[^\/]+\}/', '([^\/]+)', $route);
        $pattern = "#^" . rtrim($pattern, '/') . "$#";

        if (preg_match($pattern, $uri, $matches)) {
            array_shift($matches); // Remove o match completo
            return [$handler, $matches];
        }
    }
    return [null, []];
}

// Faz o match
[$handler, $params] = matchRoute($uri, $routes);

if ($handler) {
    [$controllerName, $method] = $handler;
    $name = "\\Controllers\\".$controllerName;
    $controller = new $name();

    if(class_exists($name)) {
        

        if (method_exists($controller, $method)) {
            call_user_func_array([$controller, $method], $params);
        } else {
            http_response_code(404);
            echo "Método '{$method}' não encontrado em {$controllerName}.";
        }
    } else {
        http_response_code(404);
        echo "Controller '{$controllerName}' não encontrado.";
    }
} else {
    http_response_code(404);
    echo "Rota '{$uri}' não encontrada.";
}
if ($nivel == null) {
    include('Views/templates/footer.php');
}

include('Views/templates/end.php');
ob_end_flush(); // <- Libera o conteúdo do buffer