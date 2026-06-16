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

    public function equipe_edit()
    {
        if (
            !isset($_SESSION['usuario_logado']) ||
            $_SESSION['usuario_logado']->cargo != 'dono'
        ) {
            redirectPage(base_url('login'));
            exit;
        }

        $id = $_GET['id'] ?? null;

        if (!$id) {
            header('Location: ' . base_url('dono/equipe'));
            exit;
        }

        $barbearia_id = $_SESSION['usuario_logado']->barbearia_id;

        // Busca o membro da equipe garantindo que pertença à mesma barbearia e não seja o dono
        $membro = $this->usuarios
            ->select(null, "id = {$id} AND barbearia_id = {$barbearia_id} AND cargo <> 'dono'")
            ->fetch(PDO::FETCH_OBJ);

        if (!$membro) {
            header('Location: ' . base_url('dono/equipe'));
            exit;
        }

        $data = [];
        $data['pagina'] = 'Editar Colaborador';

        require 'Views/dono/equipe_edit.php';
    }

    public function equipe_update()
    {
        if (
            !isset($_SESSION['usuario_logado']) ||
            $_SESSION['usuario_logado']->cargo != 'dono'
        ) {
            redirectPage(base_url('login'));
            exit;
        }

        $id = $_GET['id'] ?? null;
        $requests = $_POST;

        if ($id) {
            $dadosAtualizados = [
                'nome'            => trim($requests['nome']),
                'email'           => trim($requests['email']),
                'telefone'        => trim($requests['telefone']),
                'cargo'           => $requests['cargo'],
                'atende_clientes' => $requests['atende_clientes'],
                'status'          => $requests['status']
            ];

            // Só atualiza a senha se o dono preencher o campo na edição
            if (!empty($requests['senha'])) {
                $dadosAtualizados['senha'] = md5($requests['senha']);
            }

            if ($this->usuarios->update("id = {$id}", $dadosAtualizados)) {
                $_SESSION['msg'] = [
                    'texto' => 'Colaborador atualizado com sucesso!',
                    'color' => 'success'
                ];
            } else {
                $_SESSION['msg'] = [
                    'texto' => 'Erro ao atualizar colaborador.',
                    'color' => 'danger'
                ];
            }
        }

        header('Location: ' . base_url('dono/equipe'));
        exit;
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
        
        // Pega a data pelo link/filtro ou assume HOJE se não tiver nada selecionado
        $dataFiltro = $_GET['data'] ?? date('Y-m-d');

        // Busca apenas os agendamentos DA BARBEARIA e DA DATA SELECIONADA
        $agendamentos = $this->agendamentos->select(
            null,
            "barbearia_id = {$barbearia_id} AND data_agendamento = '{$dataFiltro}'",
            "hora_inicio ASC"
        )->fetchAll(PDO::FETCH_OBJ);

        // Prepara e limpa os dados antes de mandar para o HTML
        foreach ($agendamentos as $agendamento) {
            
            // Busca o barbeiro com segurança
            $barbeiro = $this->usuarios
                ->select(null, "id = {$agendamento->usuario_id}")
                ->fetch(PDO::FETCH_OBJ);
            
            // Busca o serviço com segurança
            $servico = $this->servicos
                ->select(null, "id = {$agendamento->servico_id}")
                ->fetch(PDO::FETCH_OBJ);

            // Se não achar o nome (se foi deletado do banco), assume um texto padrão em vez de quebrar a tela
            $agendamento->barbeiro_nome = $barbeiro->nome ?? 'Não encontrado';
            $agendamento->servico_nome = $servico->nome ?? 'Não encontrado';
            
            // Garante que a observação nunca seja nula para o htmlspecialchars não chiar
            $agendamento->observacoes = $agendamento->observacoes ?? '';
        }

        $data = [];
        $data['pagina'] = 'Agenda';
        $data['dataFiltro'] = $dataFiltro; // Manda a data atual do filtro para a View saber qual exibir no input
        $data['agendamentos'] = $agendamentos;

        require 'Views/dono/agenda.php';
    }
    public function agenda_new()
    {
        $barbearia_id = $_SESSION['usuario_logado']->barbearia_id;

        $data['barbeiros'] = $this->usuarios
            ->select(null, "barbearia_id = {$barbearia_id} AND cargo = 'barbeiro' AND status = 1")
            ->fetchAll(PDO::FETCH_CLASS);

        $data['servicos'] = $this->servicos
            ->select(null, "barbearia_id = {$barbearia_id} AND status = 1")
            ->fetchAll(PDO::FETCH_CLASS);

        // Lógica para carregar horários disponíveis via AJAX/Requisição de tela
        $barbeiro_id = $_GET['barbeiro_id'] ?? null;
        $data_busca = $_GET['data'] ?? null;
        $horarios_disponiveis = [];

        if ($barbeiro_id && $data_busca) {
            // Defina o intervalo padrão de atendimento da barbearia (ex: 08:00 às 19:00)
            $inicio = strtotime('08:00');
            $fim = strtotime('19:00');
            $intervalo = 30 * 60; // Slots de 30 em 30 minutos

            // Busca os agendamentos já ocupados daquele barbeiro naquele dia
            $ocupados = $this->agendamentos
                ->select(null, "usuario_id = {$barbeiro_id} AND data_agendamento = '{$data_busca}' AND status <> 'cancelado'")
                ->fetchAll(PDO::FETCH_OBJ);

            // Filtra os horários livres
            for ($i = $inicio; $i < $fim; $i += $intervalo) {
                $hora_atual = date('H:i', $i);
                $esta_ocupado = false;

                foreach ($ocupados as $agendamento) {
                    // Verifica se o slot atual cai dentro do intervalo de algum agendamento existente
                    if ($hora_atual >= date('H:i', strtotime($agendamento->hora_inicio)) && 
                        $hora_atual < date('H:i', strtotime($agendamento->hora_fim))) {
                        $esta_ocupado = true;
                        break;
                    }
                }

                if (!$esta_ocupado) {
                    $horarios_disponiveis[] = $hora_atual;
                }
            }
        }

        $data['horarios_disponiveis'] = $horarios_disponiveis;
        $data['barbeiro_selecionado'] = $barbeiro_id;
        $data['data_selecionada'] = $data_busca;

        extract($data);
        require 'Views/dono/agenda_form.php';
    }

    public function agenda_save()
    {
        $request = $_POST;

        // Pega os dados do serviço para calcular a duração e valor correto
        $servico = $this->servicos->select(null, "id = {$request['servico_id']}")->fetch(PDO::FETCH_OBJ);
        $hora_inicio = $request['hora_inicio'];
        $hora_fim = date('H:i', strtotime("+{$servico->duracao} minutes", strtotime($hora_inicio)));
        $data_agendamento = $request['data_agendamento'];
        $barbeiro_id = $request['barbeiro_id'];

        // TRAVA DE SEGURANÇA: Verifica se o horário foi ocupado no milissegundo anterior
        $conflito = $this->agendamentos->select(
            null,
            "usuario_id = {$barbeiro_id} 
            AND data_agendamento = '{$data_agendamento}' 
            AND status <> 'cancelado'
            AND (
                ('{$hora_inicio}' >= hora_inicio AND '{$hora_inicio}' < hora_fim) OR 
                ('{$hora_fim}' > hora_inicio AND '{$hora_fim}' <= hora_fim)
            )"
        )->fetch(PDO::FETCH_OBJ);

        if ($conflito) {
            $_SESSION['msg'] = [
                'texto' => 'Ops! Esse horário acabou de ser preenchido. Escolha outro.',
                'color' => 'danger'
            ];
            header('Location: ' . base_url("dono/agenda/new?barbeiro_id={$barbeiro_id}&data={$data_agendamento}"));
            exit;
        }

        $agendamento = [
            'barbearia_id'     => $_SESSION['usuario_logado']->barbearia_id,
            'usuario_id'       => $barbeiro_id,
            'servico_id'       => $request['servico_id'],
            'cliente_nome'     => trim($request['cliente_nome']),
            'cliente_telefone' => trim($request['cliente_telefone']),
            'data_agendamento' => $data_agendamento,
            'hora_inicio'      => $hora_inicio,
            'hora_fim'         => $hora_fim,
            'valor'            => $servico->valor,
            'observacoes'      => trim($request['observacoes']),
            'status'           => 'agendado'
        ];

        if ($this->agendamentos->insert($agendamento)) {
            $_SESSION['msg'] = ['texto' => 'Agendamento criado com sucesso!', 'color' => 'success'];
            header('Location: ' . base_url('dono/agenda'));
            exit;
        }

        $_SESSION['msg'] = ['texto' => 'Erro ao criar agendamento.', 'color' => 'danger'];
        header('Location: ' . base_url('dono/agenda/new'));
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

    public function servicos_edit()
    {
        if (
            !isset($_SESSION['usuario_logado']) ||
            $_SESSION['usuario_logado']->cargo != 'dono'
        ) {
            redirectPage(base_url('login'));
            exit;
        }

        // Pega o ID do serviço vindo da URL (ex: ?id=X)
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header('Location: ' . base_url('dono/servicos'));
            exit;
        }

        $barbearia_id = $_SESSION['usuario_logado']->barbearia_id;

        // Busca o serviço garantindo que ele pertença à barbearia do dono logado
        $servico = $this->servicos
            ->select(null, "id = {$id} AND barbearia_id = {$barbearia_id}")
            ->fetch(PDO::FETCH_OBJ);

        if (!$servico) {
            header('Location: ' . base_url('dono/servicos'));
            exit;
        }

        // Carrega a view de edição
        require 'Views/dono/servicos_edit.php';
    }

    public function servicos_update()
    {
        if (
            !isset($_SESSION['usuario_logado']) ||
            $_SESSION['usuario_logado']->cargo != 'dono'
        ) {
            redirectPage(base_url('login'));
            exit;
        }

        $id = $_GET['id'] ?? null;
        $requests = $_POST;

        if ($id) {
            $dadosAtualizados = [
                'nome'      => trim($requests['nome']),
                'descricao' => trim($requests['descricao']),
                'duracao'   => (int)$requests['duracao'],
                'valor'     => str_replace(',', '.', $requests['valor'])
            ];

            // Atualiza usando a mesma estrutura do seu configuracoes_save
            $this->servicos->update("id = {$id}", $dadosAtualizados);
        }

        header('Location: ' . base_url('dono/servicos'));
        exit;
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