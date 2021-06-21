<?php

namespace App\Controller;

use App\Entity\Techno;
use App\Form\TechnoType;
use App\Repository\TechnoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TechnoController extends AbstractController
{
    /**
     * @Route("/admin/techno/add", name="admin_techno_add")
     */
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        // instanciation of a new techno object
        $techno = new Techno();
        // creation of the form giving it the correct entity it must be associate with
        $form = $this->createForm(TechnoType::class, $techno);
        // we give the data from the request to the form
        $form->handleRequest($request);

        // is the form submitted and valid ?
        if($form->isSubmitted() && $form->isValid()){

            // the manager will save the new entity
            $entityManager->persist($techno);
            $entityManager->flush();

            return $this->redirectToRoute('admin_techno_browse');
        }

        // as long as the form is not submitted or valid we display the create view
        return $this->render('back/techno/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/technos", name="admin_techno_browse", methods={"GET"})
     */
    public function browse(TechnoRepository $technoRepository): Response
    {
        $technos = $technoRepository->findAll();

        return $this->render('back/techno/browse.html.twig', [
            'technos' => $technos,
        ]);
    }

    /**
     * @Route("/admin/techno/edit/{id<\d+>}", name="admin_techno_edit", methods={"GET","POST"})
     */
    public function edit(Techno $techno, Request $request): Response
    {
        //TODO 404

        $form = $this->createForm(TechnoType::class, $techno);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            // setting the updatedat at the current date
            $techno->setUpdatedAt(new \DateTime());

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_techno_browse');
        }


        return $this->render('back/techno/edit.html.twig', [
            'techno' => $techno,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/techno/delete/{id<\d+>}", name="admin_techno_delete", methods={"DELETE"})
     */
    public function delete(Techno $techno, Request $request, EntityManagerInterface $entityManager): Response
    {
        //TODO 404

        // we recover the token from the form
        $submittedToken = $request->request->get('token');

        // 'delete-techno' is the same value used in the template to generate the token
        if (! $this->isCsrfTokenValid('delete-techno', $submittedToken)) {
            // We send an error an 403
            throw $this->createAccessDeniedException('Are you token to me !??!??');
        }

        $entityManager->remove($techno);
        $entityManager->flush();

        return $this->redirectToRoute('admin_techno_browse');
    }
}
