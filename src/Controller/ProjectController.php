<?php

namespace App\Controller;

use App\Entity\Project;
use App\Form\ProjectType;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProjectController extends AbstractController
{
    /**
     * @Route("/admin/project/add", name="admin_project_add")
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

            return $this->redirectToRoute('admin_project_browse');
        }

        // as long as the form is not submitted or valid we display the create view
        return $this->render('back/project/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/projects", name="admin_project_browse", methods={"GET"})
     */
    public function browse(ProjectRepository $projectRepository): Response
    {
        $projects = $projectRepository->findAll();

        return $this->render('back/project/browse.html.twig', [
            'projects' => $projects,
        ]);
    }

    /**
     * @Route("/admin/project/edit/{id<\d+>}", name="admin_project_edit", methods={"GET","POST"})
     */
    public function edit(Project $project, Request $request): Response
    {
        //TODO 404

        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            // setting the updatedat at the current date
            $project->setUpdatedAt(new \DateTime());

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_project_browse');
        }


        return $this->render('back/project/edit.html.twig', [
            'project' => $project,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/project/delete/{id<\d+>}", name="admin_project_delete", methods={"DELETE"})
     */
    public function delete(Project $project, Request $request, EntityManagerInterface $entityManager): Response
    {
        //TODO 404

        // we recover the token from the form
        $submittedToken = $request->request->get('token');

        // 'delete-project' is the same value used in the template to generate the token
        if (! $this->isCsrfTokenValid('delete-project', $submittedToken)) {
            // We send an error an 403
            throw $this->createAccessDeniedException('Are you token to me !??!??');
        }

        $entityManager->remove($project);
        $entityManager->flush();

        return $this->redirectToRoute('admin_project_browse');
    }

}
