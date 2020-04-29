<?php


namespace App\Controller;

use App\Entity\Commentaires;
use App\Entity\User;
use App\Entity\Voyage;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

        $users = $this->getDoctrine()->getRepository(User::class)->findAll();
        $voyages = $this->getDoctrine()->getRepository(Voyage::class)->findAll();
        $commentaires = $this->getDoctrine()->getRepository(Commentaires::class)->findAll();

        $usersConnectes = [];
        $usersMonth = [];
        $voyagesMonth = [];
        $commentairesMonth = [];

        $delay = new DateTime('30 days ago');

        /** @var User $user */
        foreach ($users as $user) {
            if ($user->isActiveNow()) {
                $usersConnectes[] = $user;
            }
            if ($user->getDateCreation() > $delay) {
                $usersMonth[] = $user;
            }
        }

        /** @var Voyage $voyage */
        foreach ($voyages as $voyage) {
            if ($voyage->getCreatedAt() > $delay) {
                $voyagesMonth[] = $voyage;
            }
        }

        /** @var Commentaires $commentaire */
        foreach ($commentaires as $commentaire) {
            if ($commentaire->getDatePublication() > $delay) {
                $commentairesMonth[] = $commentaire;
            }
        }

        return $this->render('dashboard/index.html.twig',[
            'usersConnectes' => $usersConnectes,
            'usersMonth' => $usersMonth,
            'voyagesMonth' => $voyagesMonth,
            'commentairesMonth' => $commentairesMonth,
        ]);
    }
}