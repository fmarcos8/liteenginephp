<?php

namespace App\controllers;

use Core\Controller;
use Core\Request;

class HomeController extends Controller
{
    public function index(): string
    {
        $items = [];

        for ($i = 1; $i <= 10; $i++) {
            $items[] = new Item("Item $i", rand(1, 100)); // Criando items com quantidades aleatórias
        }

        return $this->render("home.html.twig", ["items" => $items, "query" => Request::capture()->getQuery()]);
    }
}

class Item {
    public string $name;
    public int $quantity;

    public function __construct(string $name, int $quantity) {
        $this->name = $name;
        $this->quantity = $quantity;
    }
}