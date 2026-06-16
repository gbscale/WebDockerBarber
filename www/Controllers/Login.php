<?php

namespace Controllers;

require_once("Models/Database.php");
require_once("Config/Helpers.php");

use Models\Database as Conexao;

class Login {

    private $usuarios;

    public function __construct(){
        $this->usuarios = new Conexao('usuarios');
    }

    public function index(){

        $classeBody = 'auth-page';
        return view('login/index');
    }

    public function auth(){

        $login = trim($_POST['login'] ?? '');
        $senha = trim($_POST['senha'] ?? '');

        if(empty($login) || empty($senha)){
            return $this->redirect(base_url('login'), [
                'texto' => 'Preencha usuário e senha!',
                'color' => 'danger'
            ]);
        }

        $where = "email = '{$login}'";

        $usuario = $this->usuarios
            ->select(null, $where, null, 1)
            ->fetchObject();

        if(!$usuario){
            return $this->redirect(base_url('login'), [
                'texto' => 'Usuário não encontrado!',
                'color' => 'danger'
            ]);
        }

        if($usuario->senha !== md5($senha)){
            return $this->redirect(base_url('login'), [
                'texto' => 'Senha inválida!',
                'color' => 'danger'
            ]);
        }

        if(isset($usuario->status) && $usuario->status != 1){
            return $this->redirect(base_url('login'), [
                'texto' => 'Usuário inativo!',
                'color' => 'danger'
            ]);
        }

        $_SESSION['usuario_logado'] = $usuario;

        switch($usuario->cargo){

            case 'admin':
                return $this->redirect(base_url('admin'));

            case 'dono':
                return $this->redirect(base_url('dono'));

            case 'barbeiro':
                return $this->redirect(base_url('barbeiro'));

            default:
                session_destroy();
                return $this->redirect(base_url('login'), [
                    'texto' => 'Cargo inválido!',
                    'color' => 'danger'
                ]);
        }
    }

    public function logout(){

        unset($_SESSION['usuario_logado']);
        session_destroy();

        return $this->redirect(base_url('projeto'), [
            'texto' => 'Deslogado com sucesso!',
            'color' => 'success'
        ]);
    }

    protected function redirect($path, $message = null){
        if($message){
            $_SESSION['msg'] = $message;
        }

        header("Location: {$path}");
        exit;
    }
}