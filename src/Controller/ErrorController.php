<?php

/**
 * Controller des erreurs
 * 
 * Ce controller contient uniquement les routes vers les pages d'erreurs
 * 
 * @copyright 2021 BLHL
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ErrorController extends AbstractController
{

    /**
     * @Route("/error/404", name="error404")
     */
    public function error404(): Response
    {
        return $this->render('error/error404.html.twig');
    }
}
