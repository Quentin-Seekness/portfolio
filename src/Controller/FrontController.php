<?php

namespace App\Controller;

use App\Entity\Project;
use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontController extends AbstractController
{
    /**
     * @Route("/", name="home", methods={"GET"})
     */
    public function home(ProjectRepository $projectRepository): Response
    {
        $projects = $projectRepository->findAll();

        return $this->render('front/home.html.twig', [
            'projects' => $projects,
        ]);
    }

    /**
     * @Route("/read/{id<\d+>}", name="read", methods={"GET"})
     */
    public function read(Project $project): Response
    {
        return $this->render('front/home.html.twig', [
            'project' => $project,
        ]);
    }
}
