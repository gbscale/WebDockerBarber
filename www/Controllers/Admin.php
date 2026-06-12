<?php

namespace Controllers;

require_once("Models/Database.php");
require_once("Config/Helpers.php");

use Models\Database as Conexao;
use \PDO;

class Admin{

    public function index()
    {
        return view('admin/index');
    }

    public function usuarios()
    {
        return view('admin/usuarios');
    }

    public function barbearias()
    {
        return view('admin/barbearias');
    }

    public function planos()
    {
        return view('admin/planos');
    }

    public function financeiro()
    {
        return view('admin/financeiro');
    }

}



