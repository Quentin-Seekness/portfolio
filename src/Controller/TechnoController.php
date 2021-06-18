<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TechnoController extends AbstractController
{
    /**
     * @Route("/techno", name="techno")
     */
    public function index(): Response
    {
        return $this->render('techno/index.html.twig', [
            'controller_name' => 'TechnoController',
        ]);
    }
}
