<?php

namespace App\Http\Middleware;

use Exception;

class Maintenence
{
    public function handle($request, $next)
    {
        //VERIFICA O ESTADO DE MANUTENÇÃO DA PAGINA
        if(getenv('MAINTENENCE') == 'true') {
            throw new Exception("Em manutenção",200);
            
        }

        //EXECUTA O PROXIMO DA FILA
        return $next($request);
    }
}
