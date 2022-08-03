<?php

namespace App\Controller\Pages;

use App\Model\Entity\Organization;
use App\Model\Entity\Testimony as EntityTestimony;
use App\Utils\Pagination;
use App\Utils\View;

class Testimony extends Page
{

    /**
     * Renderiza a pagina Home do Site
     */
    public static function getTestimonies($request): String
    {
        $content = View::render('pages/testmonies', [
            "items" => self::getTestimonyItems($request, $obPagination),
            "pagination" => parent::getPagination($request, $obPagination)
        ]);

        return parent::getPage('#Depoimentos', $content);
    }

    public static function insertTestimony($request)
    {
        //DADOS DO POST
        $postVars= $request->getPostVars();

        //MODEL
        $obTestimony = new EntityTestimony;
        $obTestimony->nome = $postVars['nome'];
        $obTestimony->mensagem = $postVars['mensagem'];
        $obTestimony->cadastrar();


        return self::getTestimonies($request);
    }

    private static function getTestimonyItems($request, &$obPagination)
    {
        //DEPOIMETNOS
        $items= "";

        //QTD TOTAL DE REGISTROS
        $quantidadeTotal = EntityTestimony::getTestimonies(null, null, null,'COUNT(*) as qtd')->fetchObject()->qtd;

        //QUERY PARAMS
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        //INSTACIA DE PAGINAÇÃO
        $obPagination = new Pagination($quantidadeTotal, $paginaAtual, 3);

        //RESULTADOS NA PAGINA
        $results = EntityTestimony::getTestimonies(null, "id DESC", $obPagination->getLimit());

        //RENDERIZA DOS DEPOIMETNOS
        while ($obTestimony = $results->fetchObject(EntityTestimony::class)) {
            $items .= View::render('pages/testimony/item', [
                'nome' => $obTestimony->nome,
                'mensagem' => $obTestimony->mensagem,
                'data' => date('d-m-Y H:i:s' , strtotime($obTestimony->data))
            ]);
        }

        //RETORNA OS ITEMS
        return $items;
    }
}