<?php

namespace Controllers;

require_once("Models/Database.php");
require_once("Config/Helpers.php");

use Models\Database as Conexao;
use PDO;

class Admin
{
    private $barbearias;
    private $usuarios;

    public function __construct()
    {
        if (!isset($_SESSION['usuario_logado']) || $_SESSION['usuario_logado']->cargo !== 'admin') {
            $_SESSION['msg'] = ['texto' => 'Acesso restrito!', 'color' => 'danger'];
            redirectPage(base_url('login'));
            exit;
        }

        $this->barbearias = new Conexao('barbearias');
        $this->usuarios   = new Conexao('usuarios');
    }

    public function index()
    {
        $totalBarbearias = $this->barbearias->execute("SELECT COUNT(id) as total FROM barbearias WHERE status = 1")->fetch(PDO::FETCH_OBJ)->total ?? 0;
        $totalUsuarios   = $this->usuarios->execute("SELECT COUNT(id) as total FROM usuarios")->fetch(PDO::FETCH_OBJ)->total ?? 0;
        $planosAtivos    = $this->barbearias->execute("SELECT COUNT(id) as total FROM barbearias WHERE plano != 'gratuito' AND status = 1")->fetch(PDO::FETCH_OBJ)->total ?? 0;
        $receitaMensal   = $this->barbearias->execute("SELECT SUM(valor_plano) as total FROM barbearias WHERE status = 1")->fetch(PDO::FETCH_OBJ)->total ?? 0.00;

        // Query limpa trazendo as barbearias de forma direta
        $barbearias = $this->barbearias->execute("SELECT * FROM barbearias ORDER BY id DESC")->fetchAll(PDO::FETCH_OBJ);

        require 'Views/admin/index.php';
    }
    
    public function barbearias()
    {
        $barbearias = $this->barbearias->execute("SELECT * FROM barbearias ORDER BY id DESC")->fetchAll(PDO::FETCH_OBJ);
        require 'Views/admin/barbearias.php';
    }

    public function barbearias_new()
    {
        require 'Views/admin/barbearias_form.php';
    }

    public function barbearias_create()
    {
        $request = $_POST;

        $dadosBarbearia = [
            'nome'        => trim($request['nome_barbearia']),
            'responsavel' => trim($request['nome_responsavel']),
            'plano'       => $request['plano'],
            'valor_plano' => ($request['plano'] == 'ultimate') ? 199.90 : (($request['plano'] == 'pro') ? 119.90 : 59.90),
            'status'      => 1
        ];

        if ($this->barbearias->insert($dadosBarbearia)) {
            $barbearia_id = $this->barbearias->execute("SELECT id FROM barbearias ORDER BY id DESC LIMIT 1")->fetch(PDO::FETCH_OBJ)->id;

            $dadosDono = [
                'barbearia_id' => $barbearia_id,
                'nome'         => trim($request['nome_responsavel']),
                'email'        => trim($request['email_login']),
                'senha'        => md5($request['senha_login']),
                'cargo'        => 'dono',
                'status'       => 1
            ];

            $this->usuarios->insert($dadosDono);

            header('Location: ' . base_url('admin'));
            exit;
        }

        header('Location: ' . base_url('admin/barbearias/new'));
        exit;
    }

    public function barbearias_view()
    {
        $id = $_GET['id'] ?? null;
        
        $barbearia = $this->barbearias->execute("SELECT * FROM barbearias WHERE id = {$id}")->fetch(PDO::FETCH_OBJ);
        $equipe = $this->usuarios->execute("SELECT * FROM usuarios WHERE barbearia_id = {$id}")->fetchAll(PDO::FETCH_OBJ);

        require 'Views/admin/barbearias_view.php';
    }

    public function barbearias_edit()
    {
        $id = $_GET['id'] ?? null;
        
        $barbearia = $this->barbearias->execute("SELECT * FROM barbearias WHERE id = {$id}")->fetch(PDO::FETCH_OBJ);

        require 'Views/admin/barbearias_edit.php';
    }

    public function barbearias_update()
    {
        $request = $_POST;
        $id = $request['id'];

        $dadosUpdate = [
            'nome'        => trim($request['nome_barbearia']),
            'responsavel' => trim($request['nome_responsavel']),
            'plano'       => $request['plano'],
            'valor_plano' => ($request['plano'] == 'ultimate') ? 199.90 : (($request['plano'] == 'pro') ? 119.90 : 59.90),
        ];

        $this->barbearias->update("id = {$id}", $dadosUpdate);

        header('Location: ' . base_url('admin'));
        exit;
    }

    public function barbearias_status()
    {
        $id = $_GET['id'] ?? null;
        $barbearia = $this->barbearias->execute("SELECT status FROM barbearias WHERE id = {$id}")->fetch(PDO::FETCH_OBJ);

        if ($barbearia) {
            $novoStatus = ($barbearia->status == 1) ? 0 : 1;
            
            $this->barbearias->update("id = {$id}", ['status' => $novoStatus]);
            $this->usuarios->update("barbearia_id = {$id}", ['status' => $novoStatus]);
        }

        header('Location: ' . base_url('admin'));
        exit;
    }

    public function usuarios()
    {
        $usuarios = $this->usuarios->execute("SELECT u.*, b.nome as barbearia_nome FROM usuarios u LEFT JOIN barbearias b ON u.barbearia_id = b.id ORDER BY u.id DESC")->fetchAll(PDO::FETCH_OBJ);
        require 'Views/admin/usuarios.php';
    }

    // Carrega o formulário de edição do usuário
    public function usuarios_edit()
    {
        $id = $_GET['id'] ?? null;
        
        // Busca o usuário específico
        $usuario = $this->usuarios->execute("SELECT * FROM usuarios WHERE id = {$id}")->fetch(PDO::FETCH_OBJ);
        
        // Busca todas as barbearias para o Admin poder reatar ou mover o usuário de empresa se quiser
        $barbearias = $this->barbearias->execute("SELECT id, nome FROM barbearias WHERE status = 1")->fetchAll(PDO::FETCH_OBJ);

        require 'Views/admin/usuarios_edit.php';
    }

    // Processa a atualização do usuário (inclusive troca de senha e status)
    public function usuarios_update()
    {
        $request = $_POST;
        $id = $request['id'];

        $dadosUpdate = [
            'nome'   => trim($request['nome']),
            'email'  => trim($request['email']),
            'status' => $request['status']
        ];

        // Só altera a senha se o admin realmente digitou algo no campo
        if (!empty($request['senha'])) {
            $dadosUpdate['senha'] = md5($request['senha']);
        }

        $this->usuarios->update("id = {$id}", $dadosUpdate);

        header('Location: ' . base_url('admin/usuarios'));
        exit;
    }

    public function planos()
    {
        require 'Views/admin/planos.php';
    }

    public function financeiro()
    {
        require 'Views/admin/financeiro.php';
    }

    public function configuracoes()
    {
        $id_admin = $_SESSION['usuario_logado']->id;
        $usuario = $this->usuarios->execute("SELECT * FROM usuarios WHERE id = {$id_admin}")->fetch(PDO::FETCH_OBJ);
        require 'Views/admin/configuracoes.php';
    }
}