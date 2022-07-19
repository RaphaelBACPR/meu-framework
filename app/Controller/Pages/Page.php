<?php

namespace App\Controller\Pages;

use App\Utils\View;

class Page
{
    public static function getPage(string $title, string $content): String
    {
        return View::render('pages/page', [
            'title' => $title,
            'content' => $content,
            'header' => self::getHeader(),
            'footer' => self::getFooter()
        ]);
    }

    private static function getHeader(): String
    {
        return View::render('pages/header');
    }

    private static function getFooter(): String
    {
        return View::render('pages/footer');
    }
}
