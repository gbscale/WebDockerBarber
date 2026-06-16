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
        // Trava global: se não for barbeiro, chuta para o login imediatamente
        if (!isset($_SESSION['usuario_logado']) || $_SESSION['usuario_logado']->cargo !== 'barbeiro') {
            redirectPage(base_url('login'));
            exit;
        }

        $this->usuarios = new Conexao('usuarios');
        $this->servicos = new Conexao('servicos');
        $this->agendamentos = new Conexao('agendamentos');
    }
    
    public function index()
    {
        $barbearia_id = $_SESSION['usuario_logado']->barbearia_id;
        $usuario_id = $_SESSION['usuario_logado']->id;
        $dataSelecionada = $_GET['data'] ?? date('Y-m-d');

        // Busca APENAS os agendamentos DELE
        $agendamentos = $this->agendamentos->select(
            null,
            "barbearia_id = {$barbearia_id} AND usuario_id = {$usuario_id} AND data_agendamento = '{$dataSelecionada}'",
            "hora_inicio ASC"
        )->fetchAll(PDO::FETCH_OBJ);

        $totalCortes = 0;
        $faturamentoDia = 0;

        foreach ($agendamentos as $agendamento) {
            // Só computa faturamento e contagem se o status NÃO for cancelado
            if ($agendamento->status !== 'cancelado') {
                $faturamentoDia += (float) $agendamento->valor;
                $totalCortes++;
            }
        }

        require 'Views/barbeiro/index.php';
    }
        
    public function agenda()
    {
        $barbearia_id = $_SESSION['usuario_logado']->barbearia_id;
        $usuario_id = $_SESSION['usuario_logado']->id;

        // SEGURANÇA: Ele só vê a agenda DELE, nunca a da barbearia inteira
        $agendamentos = $this->agendamentos->select(
            null,
            "barbearia_id = {$barbearia_id} AND usuario_id = {$usuario_id}",
            "data_agendamento DESC, hora_inicio ASC"
        )->fetchAll(PDO::FETCH_OBJ);

        // Buscar nomes dos serviços para não quebrar a view
        foreach ($agendamentos as $a) {
            $serv = $this->servicos->select(null, "id = {$a->servico_id}")->fetch(PDO::FETCH_OBJ);
            $a->servico_nome = $serv->nome ?? 'Não encontrado';
        }

        $data = [];
        $data['pagina'] = 'Agenda';
        $data['agendamentos'] = $agendamentos;

        require 'Views/barbeiro/agenda.php';
    }

    public function agenda_new()
    {
        $barbearia_id = $_SESSION['usuario_logado']->barbearia_id;

        // O barbeiro só pode agendar para ELE MESMO. Removida a lista de outros barbeiros.
        $data['servicos'] = $this->servicos
            ->select(null, "barbearia_id = {$barbearia_id} AND status = 1")
            ->fetchAll(PDO::FETCH_CLASS);

        extract($data);
        require 'Views/barbeiro/agenda_form.php';
    }

    public function agenda_save()
    {
        $request = $_POST;
        $usuario_id = $_SESSION['usuario_logado']->id; // Força o ID dele por segurança

        $servico = $this->servicos->select(null, "id = {$request['servico_id']}")->fetch(PDO::FETCH_OBJ);

        if (!$servico) {
            $_SESSION['msg'] = ['texto' => 'Serviço inválido.', 'color' => 'danger'];
            header('Location: '.base_url('barbeiro/agenda/new'));
            exit;
        }

        $hora_inicio = $request['hora_inicio'];
        $hora_fim = date('H:i', strtotime("+{$servico->duracao} minutes", strtotime($hora_inicio)));

        $agendamento = [
            'barbearia_id'     => $_SESSION['usuario_logado']->barbearia_id,
            'usuario_id'       => $usuario_id, // Protegido contra manipulação via POST
            'servico_id'       => $request['servico_id'],
            'cliente_nome'     => trim($request['cliente_nome']),
            'cliente_telefone' => trim($request['cliente_telefone']),
            'data_agendamento' => $request['data_agendamento'],
            'hora_inicio'      => $hora_inicio,
            'hora_fim'         => $hora_fim,
            'valor'            => $servico->preco,
            'observacoes'      => trim($request['observacoes'] ?? ''),
            'status'           => 'agendado'
        ];

        if ($this->agendamentos->insert($agendamento)) {
            $_SESSION['msg'] = ['texto' => 'Agendamento criado com sucesso!', 'color' => 'success'];
            header('Location: '.base_url('barbeiro/agenda'));
            exit;
        }

        $_SESSION['msg'] = ['texto' => 'Erro ao criar agendamento.', 'color' => 'danger'];
        header('Location: '.base_url('barbeiro/agenda/new'));
        exit;
    }

    // O barbeiro APENAS ENXERGA os serviços e preços definidos pelo dono. Ele NÃO PODE CRIAR NEM EDITAR.
    public function servicos()
    {
        $barbearia_id = $_SESSION['usuario_logado']->barbearia_id;

        $servicos = $this->servicos
            ->select(null, "barbearia_id = {$barbearia_id}", "nome ASC")
            ->fetchAll(PDO::FETCH_OBJ);

        $data = [];
        $data['pagina'] = 'Serviços';

        require 'Views/barbeiro/servicos.php';
    }

    public function configuracoes()
    {
        $usuario = $this->usuarios->select(null, "id = {$_SESSION['usuario_logado']->id}")->fetch(PDO::FETCH_OBJ);
        require 'Views/barbeiro/configuracoes.php';
    }

    public function configuracoes_save()
    {
        $request = $_POST;

        // O sub-usuário só mude dados básicos essenciais.
        $dados = [
            'nome'     => trim($request['nome']),
            'email'    => trim($request['email']),
            'telefone' => trim($request['telefone'])
        ];

        if (!empty($request['senha'])) {
            $dados['senha'] = md5($request['senha']);
        }

        $this->usuarios->update("id = {$_SESSION['usuario_logado']->id}", $dados);

        $_SESSION['msg'] = ['texto' => 'Perfil atualizado com sucesso!', 'color' => 'success'];
        header('Location: ' . base_url('barbeiro/configuracoes'));
        exit;
    }

    public function visagismo()
    {
        // Certifique-se de validar a sessão aqui se necessário
        require 'Views/barbeiro/visagismo.php';
    }

    public function visagismo_analisar()
    {
        // Força o cabeçalho JSON antes de qualquer resposta
        header('Content-Type: application/json');

        // O PHP recebe o veredito REAL processado pela IA lá no navegador
        $formatoDetectado = $_POST['formato_rosto'] ?? 'Oval';

        $iaResultados = [
            'Quadrado' => [
                'formato_rosto' => 'Rosto Quadrado (Linhas Marcantes)',
                'corte_recomendado' => 'Cortes com volume no topo e laterais mais baixas (como Undercut ou Pompadour) para suavizar os ângulos rígidos do maxilar.',
                'barba_recomendada' => 'Barba Tradicional ou no estilo Espartana, mantendo as laterais ralas e o queixo mais alongado/pontiagudo.'
            ],
            'Oval' => [
                'formato_rosto' => 'Rosto Oval (Simetria Harmônica)',
                'corte_recomendado' => 'Formato altamente versátil. Recomendado cortes Fade (Degradê) limpos, Buzz Cut (Raspado) ou cortes clássicos repartidos.',
                'barba_recomendada' => 'Qualquer estilo se adapta bem. Uma barba por fazer ou barba cheia bem desenhada valoriza os traços naturais.'
            ],
            'Redondo' => [
                'formato_rosto' => 'Rosto Redondo (Curvas Suaves)',
                'corte_recomendado' => 'Cortes angulares e com textura alta (como o Faux Hawk ou Quiff espetado) para criar a ilusão de um rosto mais comprido.',
                'barba_recomendada' => 'Barba mais comprida no queixo (estilo Lenhador) e bem raspada nas bochechas para alongar e afinar o semblante.'
            ],
            'Coração' => [
                'formato_rosto' => 'Rosto Coração / Triangular',
                'corte_recomendado' => 'Cortes de comprimento médio nas laterais com franja caída ou volume texturizado para equilibrar a testa mais larga.',
                'barba_recomendada' => 'Barba cheia tradicional. O volume nas bochechas e no maxilar é ideal para preencher o queixo estreito.'
            ],
            'Retangular' => [
                'formato_rosto' => 'Rosto Retangular / Longo',
                'corte_recomendado' => 'Cortes com franja jogada para o lado ou que distribuam o volume uniformemente pelas laterais para não alongar ainda mais a face.',
                'barba_recomendada' => 'Barba cheia nas laterais e mais curta na base do queixo, equilibrando a altura vertical do rosto.'
            ]
        ];

        $resposta = $iaResultados[$formatoDetectado] ?? $iaResultados['Oval'];

        echo json_encode($resposta);
        exit;
    }
    
}