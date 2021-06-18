<?php

namespace App\Controller;

use App\Entity\Techno;
use App\Form\TechnoType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TechnoController extends AbstractController
{
    /**
     * @Route("/admin/techno/add", name="techno_add")
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

            dd($techno);
            return $this->redirectToRoute('techno_browse');
        }

        // as long as the form is not submitted or valid we display the create view
        return $this->render('techno/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
