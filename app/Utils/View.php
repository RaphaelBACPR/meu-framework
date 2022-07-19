<?php

namespace App\Utils;

class View
{

    private static function getContentView(string $string): String
    {
        $file = __DIR__ . "/../../public/view/$string.html";

        return file_exists($file) ? file_get_contents($file) : "";
    }

    public static function render(string $view, array $vars = []): String
    {

        //CHAVES DAS VARIAVEIS
        $keys = array_keys($vars);
        $keys = array_map(function ($item) {
            return '{{'.$item.'}}';
        }, $keys);

        $contentView = self::getContentView($view);

        return str_replace($keys, array_values($vars), $contentView);
    }
}
