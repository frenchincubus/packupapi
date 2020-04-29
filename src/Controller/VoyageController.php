<?php

namespace App\Controller;

use App\Entity\Etape;
use App\Entity\Voyage;
use App\Form\VoyageType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VoyageController extends AbstractController
{
    /**
     * @Route("/admin/voyages", name="voyages")
     */
    public function voyagesAction()
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_login');
        }

        $em = $this->getDoctrine()->getManager();
        $voyages = $em->getRepository(Voyage::class)->findAll();

        return $this->render('voyage/voyages.html.twig',['voyages' => $voyages]);

    }

    /**
     * @Route("/admin/voyage/{id}/details", name="voyage_details", requirements={"id"="\d+"})
     * @param Request $request
     * @param $id
     * @return RedirectResponse|Response
     */
    public function showVoyageAction(Request $request, $id)
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_login');
        }

        if ($id) {
            $em = $this->getDoctrine()->getManager();
            $voyage = $em->getRepository(Voyage::class)->findOneBy(['id' => $id]);
            $etapes = $em->getRepository(Etape::class)->findBy(['voyageId' => $id]);

            return $this->render('voyage/voyageDetails.html.twig',["voyage" => $voyage, "etapes" => $etapes]);
        } else {
            return  $this->redirectToRoute('admin');
        }
    }

    /**
     * @Route("admin/voyage/new", name="voyage_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_login');
        }

        $voyage = new Voyage();
        $form = $this->createForm(VoyageType::class, $voyage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($voyage);
            $entityManager->flush();

            return $this->redirectToRoute('voyages');
        }

        return $this->render('voyage/new.html.twig', [
            'voyage' => $voyage,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("admin/voyage/{id}/edit", name="voyage_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Voyage $voyage
     * @return Response
     */
    public function edit(Request $request, Voyage $voyage): Response
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_login');
        }


        $form = $this->createForm(VoyageType::class, $voyage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('voyage_details', ["voyage" => $voyage, "id" => $voyage->getId()]);
        }

        return $this->render('voyage/edit.html.twig', [
            'voyage' => $voyage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("admin/voyage/{id}/delete", name="voyage_delete", methods={"DELETE"})
     * @param Request $request
     * @param Voyage $voyage
     * @return Response
     */
    public function delete(Request $request, Voyage $voyage): Response
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_login');
        }

        if ($this->isCsrfTokenValid('delete'.$voyage->getId(), $request->request->get('_token'))) {

            $voyage->setIsDeleted(true);
            $this->getDoctrine()->getManager()->flush();
        }

        return $this->redirectToRoute('voyages');
    }
}
