<?php

namespace App\Controller\Pages;

use App\Model\Entity\Organization;
use App\Utils\View;

class Home extends Page
{
    public static function getHome(): String
    {
        $obOrganization = new Organization;

        $content = View::render('pages/home', [
            'name' => $obOrganization->name,
            'role' => $obOrganization->role,
            'phoneNumber' => $obOrganization->phoneNumber,
            'email' => $obOrganization->email,
            'location' => $obOrganization->location
        ]);

        return parent::getPage('Home', $content);
    }
}
