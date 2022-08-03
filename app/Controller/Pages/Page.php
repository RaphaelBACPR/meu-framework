<?php

namespace App\Controller\Pages;

use App\Utils\View;

class Page
{

    /**
     * Renderiza a pagina master do sistema
     */
    public static function getPage(string $title, string $content): String
    {
        return View::render('pages/page', [
            'title' => $title,
            'content' => $content,
            'header' => self::getHeader(),
            'footer' => self::getFooter(),
        ]);
    }

    /**
     * Gera o Header
     */
    private static function getHeader(): String
    {
        return View::render('pages/header');
    }

    /**
     * Gera o Footer
     */
    private static function getFooter(): String
    {
        return View::render('pages/footer');
    }

    public static function getPagination($request, $obPagination)
    {

        //QUANTIDADE DE PAGINAS
        $pages = $obPagination->getPages();


        //VERDFICA A QUANTIDADE DE PAGINAS
        if (count($pages) <= 1) return "";

        //LINKS
        $links = "";

        //URL ATUAL SEM GETS
        $urlAtual = $request->getRouter()->getCurrentUrl();

        //GET
        $queryParams = $request->getQueryParams();

        //LINKS
        foreach ($pages as $page) {
            //ALTERA A PAGINA
            $queryParams['page'] = $page['page'];
            
            //LINKS
            $link = $urlAtual . "?" . http_build_query($queryParams);

            //VIEW
            $links .= View::render('pages/pagination/link',[
                'page' => $page['page'],
                "link" => $link,
                'active'=> $page['current'] ? "active" : ""
            ]);
        }

        //BOX
        return View::render('pages/pagination/box',[
            'links' => $links
        ]);

    }
}
