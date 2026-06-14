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
        require 'Views/barbeiro/configuracoes.php';
    }

    public function visagismo()
    {
        require 'Views/barbeiro/visagismo.php';
    }
}