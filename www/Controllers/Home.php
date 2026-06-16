<?php

namespace Controllers;

require_once("Models/Database.php");
require_once("Config/Helpers.php");
use Models\Database as Conexao;
use \PDO;

class Home{

    private $home;
    private $data;

    

    public function __construct(){
        // $this->cidades = new Conexao('cidades');
        $this->data['home'] = [];
    }

  

    public function index(){
        $this->data['home'] = "Home";
        $this->data['pagina'] = 'Home/index';
        $this->data['msg'] = ''; 
        $this->data['op'] = 'listar';
        return view('home/index',$this->data);
    }


    public function planos(){
        $this->data['home'] = "Planos";
        $this->data['pagina'] = 'Home/planos';
        $this->data['msg'] = ''; 
        $this->data['op'] = 'listar';
        return view('home/planos',$this->data);
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


// $dados = new Home();
// print_r($dados->index());

