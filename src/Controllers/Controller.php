<?php

namespace App\Controllers;

use App\Http\Request\Request;

abstract class Controller
{
    protected Request $request;

    public function __construct()
    {
        global $request;
        $this->request = $request;
    }
}