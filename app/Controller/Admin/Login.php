<?php

namespace App\Controller\Admin;

use App\Model\Entity\User;
use App\Session\Admin\Login as AdminLogin;
use App\Utils\View;

class Login extends Page
{
    public static function getLogin($request, $errorMessage = null)
    {

        $status = !is_null($errorMessage) ? View::render('admin/login/status', [
            'mensagem' => $errorMessage
        ]) : "";

        //CONTEUDO DA PAGINA DE LOGIN
        $content = View::render('admin/login', [
            'status' => $status
        ]);

        //RETORNA A PAGINA
        return parent::getPage('Login', $content);
    }

    public static function setLogin($request)
    {
        //POST VARS
        $postVars = $request->getPostVars();

        //FILTROS
        $email = filter_var($postVars['email'], FILTER_SANITIZE_EMAIL) ?? '';
        $senha = filter_var($postVars['senha'], FILTER_DEFAULT) ?? '';

        //BUSCA USUARIO POR EMAIL
        $obUser = User::getUserByEmail($email);
        if (!$obUser instanceof User) return self::getLogin($request, 'Email ou senha invalidos');

        //VALIDANDO SENHA
        if (!password_verify($senha, $obUser->senha)) return self::getLogin($request, 'Email ou senha invalidos');

        //SESSION LOGIN
        AdminLogin::login($obUser);

        //EXECUTA O REDIRECT
        $request->getRouter()->redirect('/admin');
    }

    public static function setLogout($request){
        //DESTROI A SESSAO DE LOGIN
        AdminLogin::logout();

        $request->getRouter()->redirect('/admin/login');

    }
}
