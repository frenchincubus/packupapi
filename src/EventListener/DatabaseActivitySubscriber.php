<?php


namespace App\EventListener;

use App\Entity\Activite;
use App\Entity\Etape;
use App\Entity\User;
use App\Entity\Voyage;
use DateTime;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class DatabaseActivitySubscriber implements EventSubscriber
{

    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getSubscribedEvents()
    {
        return [
            Events::postPersist,
            Events::postRemove,
            Events::postUpdate,
        ];
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $this->logActivity('persist', $args);
    }

    public function postRemove(LifecycleEventArgs $args)
    {
        $this->logActivity('remove', $args);
    }

    public function postUpdate(LifecycleEventArgs $args)
    {
        $this->logActivity('update', $args);
    }

    private function logActivity(string $action, LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if ($action === 'update') {

            if (!$entity instanceof User) {

                /** @var User $user */
                $user = $entity;
                $user->setDateModification(new DateTime());

            }

            if (!$entity instanceof Voyage) {

                /** @var Voyage $voyage */
                $voyage = $entity;
                $voyage->setDateModification(new DateTime());

            }

            if (!$entity instanceof Etape) {

                /** @var Etape $etape */
                $etape = $entity;
                $etape->setDateModification(new DateTime());

            }

            if (!$entity instanceof Activite) {

                /** @var Activite $activite */
                $activite = $entity;
                $activite->setDateModification(new DateTime());
            }
        }


    }

}