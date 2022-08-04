<?php

require __DIR__ . "/../vendor/autoload.php";

use App\Http\Middleware\Queue;
use App\Utils\View;
use App\Utils\Database;
use App\Utils\Environment;

//CARREGAMENTO DAS VARIAVEIS DE AMBIENTE
Environment::load(__DIR__ . "/../");

//CONSTANTE DE URL
define('URL', getenv('URL'));

//CONSTNANTES GLOBAIS
View::init([
    'URL' => URL
]);

//CONFIG DB
Database::config(
    getenv('DB_HOST'),
    getenv('DB_NAME'),
    getenv('DB_USER'),
    getenv('DB_PASS'),
    getenv('DB_PORT'),
);

//MIDDLEWARES
Queue::setMap([
    'maintenence' => App\Http\Middleware\Maintenence::class,
    'required-admin-logout' => App\Http\Middleware\RequireAdminLogout::class,
    'required-admin-login' => App\Http\Middleware\RequireAdminLogin::class
]);

//MIDDLEWARES PADROES
Queue::setDefault([
    'maintenence'
]);
