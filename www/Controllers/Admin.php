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
    private $planos;

    public function __construct()
    {
        if (!isset($_SESSION['usuario_logado']) || $_SESSION['usuario_logado']->cargo !== 'admin') {
            $_SESSION['msg'] = ['texto' => 'Acesso restrito!', 'color' => 'danger'];
            redirectPage(base_url('login'));
            exit;
        }

        $this->barbearias = new Conexao('barbearias');
        $this->usuarios   = new Conexao('usuarios');
        $this->planos     = new Conexao('planos');
    }

    public function index()
    {
        // 1. Total de barbearias ativas
        $totalBarbearias = $this->barbearias->execute("SELECT COUNT(id) as total FROM barbearias WHERE status = 1")->fetch(PDO::FETCH_OBJ)->total ?? 0;
        
        // 2. Total de usuários no ecossistema
        $totalUsuarios   = $this->usuarios->execute("SELECT COUNT(id) as total FROM usuarios")->fetch(PDO::FETCH_OBJ)->total ?? 0;
        
        // 3. Total de assinaturas ativas (Barbearias vinculadas a algum plano existente)
        $planosAtivos    = $this->barbearias->execute("SELECT COUNT(b.id) as total FROM barbearias b INNER JOIN planos p ON b.plano_id = p.id WHERE b.status = 1")->fetch(PDO::FETCH_OBJ)->total ?? 0;
        
        // 4. Receita Mensal Recorrente (MRR) somando o valor dinâmico dos planos das barbearias ativas
        $receitaMensal   = $this->barbearias->execute("SELECT SUM(p.preco) as total FROM barbearias b INNER JOIN planos p ON b.plano_id = p.id WHERE b.status = 1")->fetch(PDO::FETCH_OBJ)->total ?? 0.00;

        // 5. Query avançada trazendo as barbearias, o nome do plano associado, o nome do dono responsável e o total de funcionários dela
        $queryBarbearias = "
            SELECT 
                b.*, 
                p.nome as plano_nome,
                (SELECT u.nome FROM usuarios u WHERE u.barbearia_id = b.id AND u.cargo = 'dono' LIMIT 1) as responsavel_nome,
                (SELECT COUNT(u2.id) FROM usuarios u2 WHERE u2.barbearia_id = b.id) as total_funcionarios
            FROM barbearias b
            LEFT JOIN planos p ON b.plano_id = p.id
            ORDER BY b.id DESC
        ";
        $barbearias = $this->barbearias->execute($queryBarbearias)->fetchAll(PDO::FETCH_OBJ);

        require 'Views/admin/index.php';
    }
    
    public function barbearias()
    {
        $queryBarbearias = "
            SELECT b.*, p.nome as plano_nome 
            FROM barbearias b 
            LEFT JOIN planos p ON b.plano_id = p.id 
            ORDER BY b.id DESC
        ";
        $barbearias = $this->barbearias->execute($queryBarbearias)->fetchAll(PDO::FETCH_OBJ);
        require 'Views/admin/barbearias.php';
    }

    public function barbearias_new()
    {
        // Busca todos os planos criados pelo Admin para listar no formulário de cadastro
        $planos = $this->planos->execute("SELECT id, nome FROM planos ORDER BY preco ASC")->fetchAll(PDO::FETCH_OBJ);
        require 'Views/admin/barbearias_form.php';
    }

    public function barbearias_create()
    {
        $request = $_POST;

        $dadosBarbearia = [
            'nome'     => trim($request['nome_barbearia']),
            'plano_id' => !empty($request['plano_id']) ? (int)$request['plano_id'] : null,
            'status'   => 1
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
        $id = (int)($_GET['id'] ?? 0);
        
        $barbearia = $this->barbearias->execute("SELECT b.*, p.nome as plano_nome FROM barbearias b LEFT JOIN planos p ON b.plano_id = p.id WHERE b.id = {$id}")->fetch(PDO::FETCH_OBJ);
        $equipe = $this->usuarios->execute("SELECT * FROM usuarios WHERE barbearia_id = {$id}")->fetchAll(PDO::FETCH_OBJ);

        require 'Views/admin/barbearias_view.php';
    }

    public function barbearias_edit()
    {
        $id = (int)($_GET['id'] ?? 0);
        
        // Busca a barbearia selecionada
        $barbearia = $this->barbearias->execute("SELECT * FROM barbearias WHERE id = {$id}")->fetch(PDO::FETCH_OBJ);
        
        // 🌟 CORREÇÃO AQUI: Certifique-se de usar 'preco' no ORDER BY
        $planos = $this->planos->execute("SELECT * FROM planos ORDER BY preco ASC")->fetchAll(PDO::FETCH_OBJ);

        require 'Views/admin/barbearias_edit.php';
    }

    public function barbearias_update()
    {
        $request = $_POST;
        $id = (int)$request['id'];

        // Prepara os dados limpos baseados estritamente nas colunas atuais do banco
        $dadosUpdate = [
            'nome'     => trim($request['nome_barbearia']),
            'plano_id' => !empty($request['plano_id']) ? (int)$request['plano_id'] : null
        ];

        // Executa o update usando o seu Model Database padrão
        $this->barbearias->update("id = {$id}", $dadosUpdate);

        // Redireciona de volta para o Dashboard Master do Admin
        header('Location: ' . base_url('admin'));
        exit;
    }

    public function barbearias_status()
    {
        $id = (int)($_GET['id'] ?? 0);
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

    public function usuarios_edit()
    {
        $id = (int)($_GET['id'] ?? 0);
        
        $usuario = $this->usuarios->execute("SELECT * FROM usuarios WHERE id = {$id}")->fetch(PDO::FETCH_OBJ);
        $barbearias = $this->barbearias->execute("SELECT id, nome FROM barbearias WHERE status = 1")->fetchAll(PDO::FETCH_OBJ);

        require 'Views/admin/usuarios_edit.php';
    }

    public function usuarios_update()
    {
        $request = $_POST;
        $id = (int)$request['id'];

        $dadosUpdate = [
            'nome'   => trim($request['nome']),
            'email'  => trim($request['email']),
            'status' => (int)$request['status']
        ];

        if (!empty($request['senha'])) {
            $dadosUpdate['senha'] = md5($request['senha']);
        }

        $this->usuarios->update("id = {$id}", $dadosUpdate);

        header('Location: ' . base_url('admin/usuarios'));
        exit;
    }

    public function planos()
    {
        $planos = $this->planos->execute("SELECT * FROM planos ORDER BY preco ASC")->fetchAll(PDO::FETCH_OBJ);
        require 'Views/admin/planos.php';
    }

    public function planos_save()
    {
        $request = $_POST;

        $dadosPlano = [
            'nome'          => trim($request['nome']),
            'preco'         => (float)$request['preco'],
            'limite_cortes' => (int)$request['limite_cortes']
        ];

        if (!empty($request['id'])) {
            $id = (int)$request['id'];
            $this->planos->update("id = {$id}", $dadosPlano);
            $_SESSION['msg'] = ['texto' => 'Plano atualizado com sucesso!', 'color' => 'success'];
        } else {
            $this->planos->insert($dadosPlano);
            $_SESSION['msg'] = ['texto' => 'Novo plano criado com sucesso!', 'color' => 'success'];
        }

        header('Location: ' . base_url('admin/planos'));
        exit;
    }

    public function planos_delete()
    {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;

        if ($id) {
            $this->planos->delete("id = {$id}");
            $_SESSION['msg'] = ['texto' => 'Plano removido do sistema com sucesso!', 'color' => 'success'];
        }

        header('Location: ' . base_url('admin/planos'));
        exit;
    }

    public function financeiro()
    {
        // 1. Calcula a Receita Corrente Real (MRR) somando o preço dos planos das barbearias ativas
        $receitaReal = $this->barbearias->execute("
            SELECT SUM(p.preco) as total 
            FROM barbearias b 
            INNER JOIN planos p ON b.plano_id = p.id 
            WHERE b.status = 1
        ")->fetch(PDO::FETCH_OBJ)->total ?? 0.00;

        // 2. Conta quantas barbearias estão ativas (pagando) e quantas estão suspensas (inadimplentes)
        $ativas = $this->barbearias->execute("SELECT COUNT(id) as total FROM barbearias WHERE status = 1")->fetch(PDO::FETCH_OBJ)->total ?? 0;
        $suspensas = $this->barbearias->execute("SELECT COUNT(id) as total FROM barbearias WHERE status = 0")->fetch(PDO::FETCH_OBJ)->total ?? 0;
        
        // 3. Calcula a taxa real de inadimplência baseada nas contas suspensas
        $totalInstancias = $ativas + $suspensas;
        $taxaInadimplencia = $totalInstancias > 0 ? ($suspensas / $totalInstancias) * 100 : 0;

        // 4. Busca a lista real das barbearias ativas e o valor que cada uma gera para simular o histórico
        $historicoReal = $this->barbearias->execute("
            SELECT b.nome as barbearia_nome, b.created_at, p.nome as plano_nome, p.preco as plano_preco 
            FROM barbearias b
            INNER JOIN planos p ON b.plano_id = p.id
            WHERE b.status = 1
            ORDER BY b.id DESC
            LIMIT 10
        ")->fetchAll(PDO::FETCH_OBJ);

        require 'Views/admin/financeiro.php';
    }
    public function configuracoes()
    {
        $id_admin = $_SESSION['usuario_logado']->id;
        $usuario = $this->usuarios->execute("SELECT * FROM usuarios WHERE id = {$id_admin}")->fetch(PDO::FETCH_OBJ);
        require 'Views/admin/configuracoes.php';
    }
}