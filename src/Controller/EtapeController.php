<?php

namespace App\Controller;

use App\Entity\Etape;
use App\Form\EtapeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class EtapeController extends AbstractController
{
    /**
     * @Route("/admin/etapes", name="etapes")
     */
    public function etapesAction()
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_login');
        }

        $em = $this->getDoctrine()->getManager();
        $etapes = $em->getRepository(Etape::class)->findAll();

        return $this->render('etape/etapes.html.twig',['etapes' => $etapes]);
    }

    /**
     * @Route("admin/etape/new", name="etape_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_login');
        }

        $etape = new Etape();
        $form = $this->createForm(EtapeType::class, $etape);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($etape);
            $entityManager->flush();

            return $this->redirectToRoute('etapes');
        }

        return $this->render('etape/new.html.twig', [
            'etape' => $etape,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("admin/etape/{id}/etape_details", name="etape_show", methods={"GET"})
     * @param Etape $etape
     * @return Response
     */
    public function show(Etape $etape): Response
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_login');
        }

        return $this->render('etape/show.html.twig', [
            'etape' => $etape,
        ]);
    }

    /**
     * @Route("admin/etape/{id}/edit", name="etape_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Etape $etape
     * @return Response
     */
    public function edit(Request $request, Etape $etape): Response
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_login');
        }

        $form = $this->createForm(EtapeType::class, $etape);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('etapes');
        }

        return $this->render('etape/edit.html.twig', [
            'etape' => $etape,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("admin/etape/{id}/delete", name="etape_delete", methods={"DELETE"})
     * @param Request $request
     * @param Etape $etape
     * @return Response
     */
    public function delete(Request $request, Etape $etape): Response
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_login');
        }

        if ($this->isCsrfTokenValid('delete'.$etape->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($etape);
            $entityManager->flush();
        }

        return $this->redirectToRoute('etapes');
    }
}
