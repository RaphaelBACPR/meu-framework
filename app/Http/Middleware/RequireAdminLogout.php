<?php

namespace App\Http\Middleware;

use App\Session\Admin\Login as AdminLogin;

class RequireAdminLogout
{
    public function handle($request, $next){

        if(AdminLogin::isLogged()){
            $request->getRouter()->redirect('/admin');
        }

        return $next($request);

    }


}
