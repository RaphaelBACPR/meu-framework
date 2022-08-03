<?php

use App\Controller\Pages;
use App\Http\Response;

//ROTA HOME
$obRouter->get('/', [
    function () {
        return new Response(200, Pages\Home::getHome());
    }
]);

//ROTA SOBRE
$obRouter->get('/sobre', [
    function () {
        return new Response(200, Pages\About::getAbout());
    }
]);

// ROTA DE DEPOIMENTOS

$obRouter->get('/depoimentos', [
    function($request){
        return new Response(200, Pages\Testimony::getTestimonies($request));
    }
]);

//INSERT DE DEPOIMENTOS

$obRouter->post('/depoimentos', [
    function($request){
        return new Response(200, Pages\Testimony::insertTestimony($request));
    }
]);
