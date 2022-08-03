<?php

require __DIR__."/config/config.php";

use App\Http\Router;

//INSTANCIA DO ROTEADOR
$obRouter = new Router(URL);

//PAGINA DE ROTAS
include __DIR__ . "/routes/pages.php";

//EXECUÇÃO DAS ROTAS
$obRouter->run()->sendResponse();
