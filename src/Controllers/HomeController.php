<?php

namespace App\Controllers;

use App\Http\Response\View;

class HomeController
{
    public function index(): View
    {
        return new View("home.php");
    }
}