<?php

namespace Controllers;

require_once("Models/Database.php");
require_once("Config/Helpers.php");
use Models\Database as Conexao;
use \PDO;

class Home{

    private $home;
    private $data;
    private $planosModel; // 🌟 Nova propriedade para ler a tabela de planos

    public function __construct(){
        $this->data['home'] = [];
        // 🌟 Inicializa a conexão com a tabela de planos
        $this->planosModel = new Conexao('planos');
    }

    public function index(){
        $this->data['home'] = "Home";
        $this->data['pagina'] = 'Home/index';
        $this->data['msg'] = ''; 
        $this->data['op'] = 'listar';
        return view('home/index',$this->data);
    }

    // 🌟 ATUALIZADO: Agora busca os planos reais do banco para mandar para a vitrine
    public function planos(){
        $this->data['home'] = "Planos";
        $this->data['pagina'] = 'Home/planos';
        $this->data['msg'] = ''; 
        $this->data['op'] = 'listar';
        
        // Busca os planos ordenados pelo preço (do mais barato ao mais caro)
        $this->data['planos'] = $this->planosModel->execute("SELECT * FROM planos ORDER BY preco ASC")->fetchAll(PDO::FETCH_OBJ);

        return view('home/planos', $this->data);
    }

    public function recursos(){
        $this->data['home'] = "Recursos";
        $this->data['pagina'] = 'Home/recursos';
        $this->data['msg'] = ''; 
        $this->data['op'] = 'listar';
        return view('home/recursos',$this->data);
    }

    public function contato(){
        $this->data['home'] = "Contato";
        $this->data['pagina'] = 'Home/contato';
        $this->data['msg'] = ''; 
        $this->data['op'] = 'listar';
        return view('home/contato',$this->data);
    }
}