<?php

namespace App\Controller\Pages;

use App\Model\Entity\Organization;
use App\Utils\View;

class About extends Page
{

    /**
     * Renderiza a pagina Home do Site
     */
    public static function getAbout(): String
    {
        $obOrganization = new Organization;

        $content = View::render('pages/about', [
            'name' => $obOrganization->name,
            'role' => $obOrganization->role
        ]);

        return parent::getPage('Sobre', $content);
    }
}