<?php

namespace Controllers;

require_once("Models/Database.php");
require_once("Config/Helpers.php");

use Models\Database as Conexao;
use PDO;

class Dono
{
    private $usuarios;
    private $servicos;
    private $agendamentos;
    private $barbearias;


    public function __construct()
    {
        $this->usuarios = new Conexao('usuarios');
        $this->servicos = new Conexao('servicos');
        $this->agendamentos = new Conexao('agendamentos');
        $this->barbearias = new Conexao('barbearias');

    }
    
   public function index()
    {
        $barbearia_id = $_SESSION['usuario_logado']->barbearia_id;

        $dataSelecionada = $_GET['data'] ?? date('Y-m-d');
        $mesAtual = date('Y-m');

        // Agendamentos do dia
        $agendamentos = $this->agendamentos
            ->select(
                null,
                "barbearia_id = {$barbearia_id}
                AND data_agendamento = '{$dataSelecionada}'",
                "hora_inicio ASC"
            )
            ->fetchAll(PDO::FETCH_OBJ);

        foreach ($agendamentos as $agendamento) {

            $barbeiro = $this->usuarios
                ->select(null, "id = {$agendamento->usuario_id}")
                ->fetch(PDO::FETCH_OBJ);

            $servico = $this->servicos
                ->select(null, "id = {$agendamento->servico_id}")
                ->fetch(PDO::FETCH_OBJ);

            $agendamento->barbeiro_nome = $barbeiro->nome ?? '-';
            $agendamento->servico_nome = $servico->nome ?? '-';
        }

        // Total de agendamentos
        $totalAgendamentos = count($agendamentos);

        // Faturamento do dia
        $faturamentoHoje = 0;

        foreach ($agendamentos as $agendamento) {
            $faturamentoHoje += (float) $agendamento->valor;
        }

        // Clientes atendidos
        $clientes = [];

        foreach ($agendamentos as $agendamento) {
            $clientes[] = $agendamento->cliente_telefone;
        }

        $clientesAtendidos = count(array_unique($clientes));

        // Barbeiros ativos
        $barbeiros = $this->usuarios
            ->select(
                null,
                "barbearia_id = {$barbearia_id}
                AND cargo = 'barbeiro'
                AND status = 1"
            )
            ->fetchAll(PDO::FETCH_OBJ);

        $barbeirosAtivos = count($barbeiros);

        // Faturamento do mês
        $agendamentosMes = $this->agendamentos
            ->select(
                null,
                "barbearia_id = {$barbearia_id}
                AND data_agendamento LIKE '{$mesAtual}%'"
            )
            ->fetchAll(PDO::FETCH_OBJ);

        $faturamentoMes = 0;

        foreach ($agendamentosMes as $agendamento) {
            $faturamentoMes += (float) $agendamento->valor;
        }

        // Ticket médio
        $ticketMedio = $totalAgendamentos > 0
            ? $faturamentoHoje / $totalAgendamentos
            : 0;

        // Valores temporários
        $servicoMaisVendido = 'Em desenvolvimento';
        $taxaOcupacao = 0;
        $rankingBarbeiros = [];

        require 'Views/dono/index.php';
    }

    public function equipe()
    {
        if (
            !isset($_SESSION['usuario_logado']) ||
            $_SESSION['usuario_logado']->cargo != 'dono'
        ) {
            redirectPage(base_url('login'));
            exit;
        }

        $barbearia_id = $_SESSION['usuario_logado']->barbearia_id;

        $equipe = $this->usuarios
            ->select(
                null,
                "barbearia_id = {$barbearia_id} AND cargo <> 'dono'",
                null,
                null
            )
            ->fetchAll(PDO::FETCH_CLASS);

        $data = [];
        $data['pagina'] = 'Minha Equipe';

        require 'Views/dono/equipe.php';
    }

    public function equipe_new()
    {
        $data = [];

        $data['pagina'] = 'Novo Barbeiro';

        require 'Views/dono/equipe_form.php';
    }

    public function equipe_save()
    {
        if (
            !isset($_SESSION['usuario_logado']) ||
            $_SESSION['usuario_logado']->cargo != 'dono'
        ) {
            redirectPage(base_url('login'));
            exit;
        }

        $requests = $_POST;

        $usuario = [
            'barbearia_id'    => $_SESSION['usuario_logado']->barbearia_id,
            'nome'            => trim($requests['nome']),
            'email'           => trim($requests['email']),
            'telefone'        => trim($requests['telefone']),
            'senha'           => md5($requests['senha']),
            'cargo'           => $requests['cargo'],
            'atende_clientes' => $requests['atende_clientes'],
            'agenda_ativa'    => 1,
            'status'          => 1,
            'created_at'      => date('Y-m-d H:i:s')
        ];

        if ($this->usuarios->insert($usuario)) {

            $_SESSION['msg'] = [
                'texto' => 'Colaborador cadastrado com sucesso!',
                'color' => 'success'
            ];

            header('Location: ' . base_url('dono/equipe'));
            exit;
        }

        $_SESSION['msg'] = [
            'texto' => 'Erro ao cadastrar colaborador.',
            'color' => 'danger'
        ];

        header('Location: ' . base_url('dono/equipe/new'));
        exit;
    }

    public function agenda()
    {
        if (
            !isset($_SESSION['usuario_logado']) ||
            $_SESSION['usuario_logado']->cargo != 'dono'
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

        require 'Views/dono/agenda.php';
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

        require 'Views/dono/agenda_form.php';
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

            'valor' => $servico->valor,

            'observacoes' => trim($request['observacoes']),

            'status' => 'agendado'
        ];

        if($this->agendamentos->insert($agendamento)){

            $_SESSION['msg'] = [
                'texto' => 'Agendamento criado com sucesso!',
                'color' => 'success'
            ];

            header('Location: '.base_url('dono/agenda'));
            exit;
        }

        $_SESSION['msg'] = [
            'texto' => 'Erro ao criar agendamento.',
            'color' => 'danger'
        ];

        header('Location: '.base_url('dono/agenda/new'));
        exit;
    }
    public function servicos()
    {
        if (
            !isset($_SESSION['usuario_logado']) ||
            $_SESSION['usuario_logado']->cargo != 'dono'
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

        require 'Views/dono/servicos.php';
    }

    public function servicos_new()
    {
        require 'Views/dono/servicos_form.php';
    }

    public function servicos_save()
    {
        $requests = $_POST;

        $servico = [

            'barbearia_id' => $_SESSION['usuario_logado']->barbearia_id,

            'nome' => trim($requests['nome']),

            'descricao' => trim($requests['descricao']),

            'duracao' => (int)$requests['duracao'],

            'valor' => str_replace(',', '.', $requests['valor']),

            'status' => 1,

            'created_at' => date('Y-m-d H:i:s')
        ];

        $this->servicos->insert($servico);

        header('Location: '.base_url('dono/servicos'));
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

        $barbearia = $this->barbearias
            ->select(
                null,
                "id = {$_SESSION['usuario_logado']->barbearia_id}"
            )
            ->fetch(PDO::FETCH_OBJ);

        require 'Views/dono/configuracoes.php';
    }

    public function configuracoes_save()
    {
        $request = $_POST;

        $dadosBarbearia = [

            'nome' => trim($request['nome_barbearia']),
            'telefone' => trim($request['telefone_barbearia']),
            'email' => trim($request['email_barbearia'])

        ];

        $this->barbearias->update(
            "id = {$_SESSION['usuario_logado']->barbearia_id}",
            $dadosBarbearia
        );

        $dadosUsuario = [

            'nome' => trim($request['nome']),
            'email' => trim($request['email']),
            'telefone' => trim($request['telefone'])

        ];

        if (!empty($request['senha'])) {
            $dadosUsuario['senha'] = md5($request['senha']);
        }

        $this->usuarios->update(
            "id = {$_SESSION['usuario_logado']->id}",
            $dadosUsuario
        );

        $_SESSION['msg'] = [
            'texto' => 'Configurações atualizadas com sucesso!',
            'color' => 'success'
        ];

        header('Location: ' . base_url('dono/configuracoes'));
        exit;
    }

    public function visagismo()
    {
        require 'Views/dono/visagismo.php';
    }
}