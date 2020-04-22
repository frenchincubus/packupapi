<?php


namespace App\Controller;


use App\Entity\Activite;
use App\Entity\Commentaires;
use App\Entity\Etape;
use App\Entity\User;
use App\Entity\Voyage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{

    /**
     * @Route("/admin", name="admin")
     */
    public function indexAction()
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_login');
        }


        return $this->render('dashboard/index.html.twig');
    }

    /**
     * @Route("/admin/users", name="users")
     */
    public function usersAction()
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_login');
        }

        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository(User::class)->findAll();

        return $this->render('dashboard/users.html.twig',['users' => $users]);
    }


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

        return $this->render('dashboard/voyages.html.twig',['voyages' => $voyages]);

    }


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

        return $this->render('dashboard/etapes.html.twig',['etapes' => $etapes]);
    }


    /**
     * @Route("/admin/activites", name="activites")
     */
    public function activitesAction()
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_login');
        }

        $em = $this->getDoctrine()->getManager();
        $activites = $em->getRepository(Activite::class)->findAll();

        return $this->render('dashboard/activites.html.twig',['activites' => $activites]);
    }


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

        return $this->render('dashboard/commentaires.html.twig',['commentaires' => $commentaires]);

    }

    /**
     * @Route("/admin/user/{id}", name="user_details", requirements={"id"="\d+"})
     * @param Request $request
     * @param $id
     * @return RedirectResponse|Response
     */
    public function showUserAction(Request $request,$id)
    {
        if ($id) {
            $em = $this->getDoctrine()->getManager();
            /** @var User $user */
            $user = $em->getRepository(User::class)->findOneBy(['id' => $id]);
            $amis = $user->getAmis();
            $users = $user->getUsers();
            $voyagesSuivis = $user->getVoyagesSuivis();
            $voyages = $em->getRepository(Voyage::class)->findBy(['userId' => $user]);
            $commentaires = $em->getRepository(Commentaires::class)->findBy(['userId' => $user]);

            return $this->render('dashboard/userDetails.html.twig',['user' => $user,]);
        } else {

            return  $this->redirectToRoute('users');
        }
    }

    /**
     * @Route("/admin/voyage/{id}", name="voyage_details", requirements={"id"="\d+"})
     * @param Request $request
     * @param $id
     * @return RedirectResponse|Response
     */
    public function showVoyageAction(Request $request, $id)
    {
        $error = false;
        if ($id) {
            $em = $this->getDoctrine()->getManager();
            $voyage = $em->getRepository(Voyage::class)->findOneBy(['id' => $id]);
            $etapes = $em->getRepository(Etape::class)->findBy(['voyageId' => $id]);

            return $this->render('dashboard/voyageDetails.html.twig',["voyage" => $voyage, "etapes" => $etapes]);
        } else {
            $error = true;
            return  $this->redirectToRoute('admin');
        }

    }

}