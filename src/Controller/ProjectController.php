<?php

namespace App\Controller;

use App\Entity\Project;
use App\Form\ProjectType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProjectController extends AbstractController
{
    /**
     * @Route("/admin/project/add", name="project_add")
     */
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        // instanciation of a new project object
        $project = new Project();
        // creation of the form giving it the correct entity it must be associate with
        $form = $this->createForm(ProjectType::class, $project);
        // we give the data from the request to the form
        $form->handleRequest($request);

        // is the form submitted and valid ?
        if($form->isSubmitted() && $form->isValid()){

            // the manager will save the new entity
            $entityManager->persist($project);
            $entityManager->flush();

            dd($project);
            return $this->redirectToRoute('project_browse');
        }

        // as long as the form is not submitted or valid we display the create view
        return $this->render('project/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
