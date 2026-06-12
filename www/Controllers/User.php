<?php

namespace Controllers;

require_once("Models/Database.php");
require_once("Config/Helpers.php");

use Models\Database as Conexao;
use \PDO;

class User{

    function __construct(){
        # $this->usuarios = new Conexao('usuarios');
    }

    protected function redirect($path, $message = null) {
        if ($message) {
            $_SESSION['msg'] = $message;
        }
        header("Location: {$path}");
        exit;
    }

    //R - Função Listar todas os registros de uma tabela do BD
    function index(){
        $data = [];
        $data['pagina'] = 'User';
        $data['msg'] = '';
        return view('user/index',$data);
    }

}



