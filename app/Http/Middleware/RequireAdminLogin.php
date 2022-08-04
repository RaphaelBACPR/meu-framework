<?php

namespace App\Http\Middleware;

use App\Session\Admin\Login as AdminLogin;

class RequireAdminLogin
{
    public function handle($request, $next){

        if(!AdminLogin::isLogged()){
            $request->getRouter()->redirect('/admin/login');
        }

        return $next($request);

    }


}
