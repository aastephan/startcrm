<?php

namespace App\Controllers;

class Accueil extends BaseController
{
    public function index(): string
    {
        return view('accueil_view');
    }
}
