<?php

namespace App\Controller;

use App\Entity\Commentaires;
use App\Form\CommentairesType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class CommentairesController extends AbstractController
{
    /**
     * @Route("/admin/commentaires", name="commentaires")
     */
    public function commentairesAction()
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_login');
        }

        $em = $this->getDoctrine()->getManager();
        $commentaires = $em->getRepository(Commentaires::class)->findAll();

        return $this->render('commentaires/commentaires.html.twig',['commentaires' => $commentaires]);

    }

    /**
     * @Route("admin/commentaire/new", name="commentaires_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_login');
        }

        $commentaire = new Commentaires();
        $form = $this->createForm(CommentairesType::class, $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($commentaire);
            $entityManager->flush();

            return $this->redirectToRoute('commentaires');
        }

        return $this->render('commentaires/new.html.twig', [
            'commentaire' => $commentaire,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("admin/commentaire/{id}/details", name="commentaires_show", methods={"GET"})
     * @param Commentaires $commentaire
     * @return Response
     */
    public function show(Commentaires $commentaire): Response
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_login');
        }

        return $this->render('commentaires/show.html.twig', [
            'commentaire' => $commentaire,
        ]);
    }

    /**
     * @Route("admin/commentaire/{id}/edit", name="commentaires_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Commentaires $commentaire
     * @return Response
     */
    public function edit(Request $request, Commentaires $commentaire): Response
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_login');
        }

        $form = $this->createForm(CommentairesType::class, $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('commentaires');
        }

        return $this->render('commentaires/edit.html.twig', [
            'commentaire' => $commentaire,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("admin/commentaire/{id}/delete", name="commentaires_delete", methods={"DELETE"})
     * @param Request $request
     * @param Commentaires $commentaire
     * @return Response
     */
    public function delete(Request $request, Commentaires $commentaire): Response
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_login');
        }

        if ($this->isCsrfTokenValid('delete'.$commentaire->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($commentaire);
            $entityManager->flush();
        }

        return $this->redirectToRoute('commentaires');
    }
}
