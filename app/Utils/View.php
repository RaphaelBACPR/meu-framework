<?php

namespace App\Utils;

class View
{

    private static array $vars;

    public static function init(array $vars = []): void
    {
        self::$vars = $vars;
    }

    /**
     * Captura a view na pasta e monta o layout
     */
    private static function getContentView(string $string): String
    {
        //BUSCA A VIEW EM SUA PASTA
        $file = __DIR__ . "/../../public/view/$string.html";

        //RETORNA A VIEW SE A MESMA EXISTIR
        return file_exists($file) ? file_get_contents($file) : "";
    }

    /**
     * Renderiza a View para o User
     */
    public static function render(string $view, array $vars = []): String
    {
        
        $vars = array_merge(self::$vars, $vars);

        //CHAVES DAS VARIAVEIS
        $keys = array_keys($vars);
        $keys = array_map(function ($item) {
            return '{{'.$item.'}}';
        }, $keys);

        // CONTEUDO DA VIEW
        $contentView = self::getContentView($view);

        //RETORNA A VIEW RENDERIZADA COM SUAS VARIAVEIS
        return str_replace($keys, array_values($vars), $contentView);
    }
}
