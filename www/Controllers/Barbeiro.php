<?php

namespace Controllers;

class Barbeiro
{
    public function index()
    {
        require 'Views/barbeiro/index.php';
    }

    public function agenda()
    {
        require 'Views/barbeiro/agenda.php';
    }

    public function servicos()
    {
        require 'Views/barbeiro/servicos.php';
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