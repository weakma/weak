<?php

namespace App\Controller\Frontend;

use App\Controller\AbstractController;


class DefaultController extends AbstractController
{

    public function index()
    {


        return $this->render('frontend/index.html.twig', [
            'controller_name' => 'FrontendDefaultController',
        ]);
    }
}
