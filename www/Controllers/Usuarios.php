<?php

namespace Controllers;

require_once("Models/Database.php");
require_once("Config/Helpers.php");

use Models\Database as Conexao;
use PDO;

class Usuarios
{
    private $usuarios;
    private $barbearias;

    function __construct()
    {
        $this->usuarios = new Conexao('usuarios');
        $this->barbearias = new Conexao('barbearias');
    }

    protected function redirect($path, $message = null)
    {
        if ($message) {
            $_SESSION['msg'] = $message;
        }

        header("Location: {$path}");
        exit;
    }

    // Chama o formulário de cadastro
    function new()
    {
        $data = [];

        $data['usuarios'] = (object) [
            'nome_barbearia' => '',
            'nome'           => '',
            'email'          => '',
            'telefone'       => '',
            'senha'          => ''
        ];

        $data['pagina'] = 'Cadastrar Barbearia';
        $data['method'] = 'save';

        return view('usuarios/form', $data);
    }

    // C - Função Cadastrar
    public function save()
    {
        $requests = $_POST;

        // Cadastra a barbearia
        $barbearia = [
            'nome'       => trim($requests['nome_barbearia']),
            'telefone'   => trim($requests['telefone']),
            'email'      => trim($requests['email']),
            'status'     => 1,
            'created_at' => date('Y-m-d H:i:s')
        ];

        $barbearia_id = $this->barbearias->insert($barbearia);

        // Cadastra o usuário dono
        $usuario = [
            'barbearia_id'     => $barbearia_id,
            'nome'             => trim($requests['nome']),
            'email'            => trim($requests['email']),
            'telefone'         => trim($requests['telefone']),
            'senha'            => md5($requests['senha']),
            'cargo'            => 'dono',
            'atende_clientes'  => 1,
            'agenda_ativa'     => 1,
            'status'           => 1,
            'created_at'       => date('Y-m-d H:i:s')
        ];

        if ($this->usuarios->insert($usuario)) {
            return $this->redirect(
                base_url('login'),
                [
                    'texto' => 'Cadastro realizado com sucesso!',
                    'color' => 'success'
                ]
            );
        }

        return $this->redirect(
            base_url('usuarios/new'),
            [
                'texto' => 'Erro ao cadastrar.',
                'color' => 'danger'
            ]
        );
    }

    // R - Função Listar todas os registros de uma tabela do BD
    function index()
    {
        $classeBody = 'auth-page';
        $data = [];

        $data['usuarios'] = $this->usuarios
            ->select($join = null, $where = null, $order = null, $limit = null)
            ->fetchAll(PDO::FETCH_CLASS);

        $data['pagina'] = 'Listar usuarios';
        $data['msg'] = '';

        return view('usuarios/index', $data);
    }

    // R - Função editar - Lista um registro da tabela filtrado por id
    function edit($id)
    {
        $data = [];

        $id = (int) $id;

        $data['usuarios'] = $this->usuarios
            ->select($join = null, 'id = ' . $id)
            ->fetchObject();

        $data['pagina'] = 'Alterar usuarios';
        $data['method'] = 'edit_save';

        return view('usuarios/form', $data);
    }

    // R - Função Pesquisar por um valor
    function search()
    {
        $data = [];
        $requests = $_POST;

        $data['msg'] = '';

        if (isset($requests['pesquisar'])) {

            $join = null;
            $where = null;
            $order = null;
            $limit = null;

            $pesquisar = trim($requests['pesquisar']);

            $where = 'nome like "%' . $pesquisar . '%"
                     or email like "%' . $pesquisar . '%"';

            $data['usuarios'] = $this->usuarios
                ->select($join, $where, $order, $limit)
                ->fetchAll(PDO::FETCH_CLASS);

            $data['msg'] = flash(
                "Total de registros: " . count($data['usuarios'])
            );

            $data['pagina'] = 'Pesquisar usuarios';

            return view('usuarios/index', $data);
        } else {
            $this->index();
        }
    }

    // U - Função Alterar
    function edit_save()
    {
        $data = [];
        $requests = $_POST;

        $values = [
            'nome'     => trim($requests['nome']),
            'email'    => trim($requests['email']),
            'telefone' => trim($requests['telefone'])
        ];

        if (
            $this->usuarios->update(
                'id = ' . (int) $requests['id'],
                $values
            )
        ) {
            $data['msg'] = flash('Alterado com Sucesso!');
        } else {
            $data['msg'] = flash('Não foi alterado!', 'danger');
        }

        $data['usuarios'] = $this->usuarios
            ->select($join = null, $where = null, $order = null, $limit = null)
            ->fetchAll(PDO::FETCH_CLASS);

        $data['pagina'] = 'Listar usuarios';

        return view('usuarios/index', $data);
    }

    // D - Função Deletar
    function delete($id)
    {
        $id = (int) $id;

        $data = [];

        if ($this->usuarios->delete('id = ' . $id)) {
            $data['msg'] = flash("Excluido com Sucesso!");
        } else {
            $data['msg'] = flash("Não foi Excluido!", "danger");
        }

        $data['usuarios'] = $this->usuarios
            ->select($join = null, $where = null, $order = null, $limit = null)
            ->fetchAll(PDO::FETCH_CLASS);

        $data['pagina'] = 'Listar usuarios';

        return view('usuarios/index', $data);
    }
}