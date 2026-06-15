<?php

namespace Controllers;

require_once("Models/Database.php");
require_once("Config/Helpers.php");

use Models\Database as Conexao;
use PDO;

class Barbeiro
{
    private $usuarios;
    private $servicos;
    private $agendamentos;


    public function __construct()
    {
        $this->usuarios = new Conexao('usuarios');
        $this->servicos = new Conexao('servicos');
        $this->agendamentos = new Conexao('agendamentos');

    }
    
    public function index()
    {
        $barbearia_id = $_SESSION['usuario_logado']->barbearia_id;
        $usuario_id = $_SESSION['usuario_logado']->id;

        $dataSelecionada = $_GET['data'] ?? date('Y-m-d');

        // Busca apenas os agendamentos do barbeiro logado
        $agendamentos = $this->agendamentos->select(
            null,
            "barbearia_id = {$barbearia_id}
            AND usuario_id = {$usuario_id}
            AND data_agendamento = '{$dataSelecionada}'",
            "hora_inicio ASC"
        )->fetchAll(PDO::FETCH_OBJ);

        // Total de cortes do dia
        $totalCortes = count($agendamentos);

        // Faturamento do dia
        $faturamentoDia = 0;

        foreach ($agendamentos as $agendamento) {
            $faturamentoDia += (float) $agendamento->valor;
        }

        require 'Views/barbeiro/index.php';
    }
        
    
    public function agenda()
    {
        if (
            !isset($_SESSION['usuario_logado']) ||
            $_SESSION['usuario_logado']->cargo != 'barbeiro'
        ) {
            redirectPage(base_url('login'));
            exit;
        }

        $barbearia_id = $_SESSION['usuario_logado']->barbearia_id;

        $agendamentos = $this->agendamentos->select(
            null,
            "barbearia_id = {$barbearia_id}",
            "data_agendamento DESC, hora_inicio ASC"
        )->fetchAll(PDO::FETCH_OBJ);

        $data = [];
        $data['pagina'] = 'Agenda';
        $data['agendamentos'] = $agendamentos;

        require 'Views/barbeiro/agenda.php';
    }
    public function agenda_new()
    {
        $data = [];

        $barbearia_id = $_SESSION['usuario_logado']->barbearia_id;

        $data['barbeiros'] = $this->usuarios
            ->select(null,
                "barbearia_id = {$barbearia_id}
                AND cargo = 'barbeiro'
                AND status = 1")
            ->fetchAll(PDO::FETCH_CLASS);

        $data['servicos'] = $this->servicos
            ->select(null,
                "barbearia_id = {$barbearia_id}
                AND status = 1")
            ->fetchAll(PDO::FETCH_CLASS);

        extract($data);

        require 'Views/barbeiro/agenda_form.php';
    }

    public function agenda_save()
    {
        $request = $_POST;

        // pega serviço
        $servico = $this->servicos->select(
            null,
            "id = {$request['servico_id']}"
        )->fetch(PDO::FETCH_OBJ);

        $hora_inicio = $request['hora_inicio'];

        // calcula hora fim automaticamente
        $hora_fim = date(
            'H:i',
            strtotime("+{$servico->duracao} minutes", strtotime($hora_inicio))
        );

        $agendamento = [

            'barbearia_id' => $_SESSION['usuario_logado']->barbearia_id,

            'usuario_id'   => $request['barbeiro_id'],

            'servico_id'   => $request['servico_id'],

            'cliente_nome' => trim($request['cliente_nome']),

            'cliente_telefone' => trim($request['cliente_telefone']),

            'data_agendamento' => $request['data_agendamento'],

            'hora_inicio' => $hora_inicio,

            'hora_fim' => $hora_fim,

            'valor' => $servico->preco,

            'observacoes' => trim($request['observacoes']),

            'status' => 'agendado'
        ];

        if($this->agendamentos->insert($agendamento)){

            $_SESSION['msg'] = [
                'texto' => 'Agendamento criado com sucesso!',
                'color' => 'success'
            ];

            header('Location: '.base_url('barbeiro/agenda'));
            exit;
        }

        $_SESSION['msg'] = [
            'texto' => 'Erro ao criar agendamento.',
            'color' => 'danger'
        ];

        header('Location: '.base_url('barbeiro/agenda/new'));
        exit;
    }
    public function servicos()
    {
        if (
            !isset($_SESSION['usuario_logado']) ||
            $_SESSION['usuario_logado']->cargo != 'barbeiro'
        ) {
            redirectPage(base_url('login'));
            exit;
        }

        $barbearia_id = $_SESSION['usuario_logado']->barbearia_id;

        $servicos = $this->servicos
            ->select(null, "barbearia_id = {$barbearia_id}", "nome ASC")
            ->fetchAll(PDO::FETCH_OBJ);

        $data = [];
        $data['pagina'] = 'Serviços';

        require 'Views/barbeiro/servicos.php';
    }

    public function servicos_new()
    {
        require 'Views/barbeiro/servicos_form.php';
    }

    public function servicos_save()
    {
        $requests = $_POST;

        $servico = [

            'barbearia_id' => $_SESSION['usuario_logado']->barbearia_id,

            'nome' => trim($requests['nome']),

            'descricao' => trim($requests['descricao']),

            'duracao' => (int)$requests['duracao'],

            'preco' => str_replace(',', '.', $requests['preco']),

            'status' => 1,

            'created_at' => date('Y-m-d H:i:s')
        ];

        $this->servicos->insert($servico);

        header('Location: '.base_url('barbeiro/servicos'));
        exit;
    }

    public function configuracoes()
    {
        $usuario = $this->usuarios
            ->select(
                null,
                "id = {$_SESSION['usuario_logado']->id}"
            )
            ->fetch(PDO::FETCH_OBJ);

        require 'Views/barbeiro/configuracoes.php';
    }

    public function configuracoes_save()
    {
        $request = $_POST;

        $dados = [

            'nome' => trim($request['nome']),
            'email' => trim($request['email']),
            'telefone' => trim($request['telefone']),
            'atende_clientes' => $request['atende_clientes'],
            'agenda_ativa' => $request['agenda_ativa']
        ];

        if (!empty($request['senha'])) {
            $dados['senha'] = md5($request['senha']);
        }

        $this->usuarios->update(
            "id = {$_SESSION['usuario_logado']->id}",
            $dados
        );

        $_SESSION['msg'] = [
            'texto' => 'Configurações atualizadas com sucesso!',
            'color' => 'success'
        ];

        header('Location: ' . base_url('barbeiro/configuracoes'));
        exit;
    }
    public function visagismo()
    {
        require 'Views/barbeiro/visagismo.php';
    }
}