<?php

namespace App\DataFixtures;

use App\Entity\Activite;
use App\Entity\Commentaires;
use App\Entity\Etape;
use App\Entity\User;
use App\Entity\Voyage;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Faker;

class AppFixtures extends Fixture
{

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        /** BUNDLE FAKER */
        $faker = Faker\Factory::create('fr_FR');

        /** USER TEST */
        $userTest = new User();
        $userTest->setEmail("test@gmail.fr");
        $userTest->setRoles($userTest->getRoles());
        $userTest->setNom("test");
        $userTest->setPrenom("test");
        $userTest->setAge($faker->numberBetween(18, 80));
        $password = $this->encoder->encodePassword($userTest, "test");
        $userTest->setPassword($password);
        $userTest->setPhoto($faker->imageUrl());
        $manager->persist($userTest);
        $manager->flush();

        /** USER ADMIN */
        $userAdmin = new User();
        $userAdmin->setEmail("admin@gmail.com");
        $userAdmin->setRoles(["ROLE_ADMIN"]);
        $userAdmin->setNom("admin");
        $userAdmin->setPrenom("admin");
        $userAdmin->setAge(37);
        $passwordadmin = $this->encoder->encodePassword($userAdmin, "admin");
        $userAdmin->setPassword($passwordadmin);
        $manager->persist($userAdmin);
        $manager->flush();

        /** GENERATE 10 RANDOM USERS */
        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setEmail($faker->email);
            $user->setNom($faker->name);
            $user->setPrenom($faker->firstName);
            $user->setAge($faker->numberBetween(18, 80));
            $password = $this->encoder->encodePassword($user, 1234);
            $user->setPassword($password);
            $user->setRoles($user->getRoles());
            $user->setPhoto($faker->imageUrl());
            $manager->persist($user);
        }
        $manager->flush();

        $users = $manager->getRepository(User::class)->findAll();


        /** GENERATE 6 VOYAGES */
        for ($i = 0; $i < 6; $i++) {
            $voyage = new Voyage();
            $voyage->setBudget($faker->numberBetween(300, 10000));
            $voyage->setName($faker->country . " " . $faker->name);
            $voyage->setDateDebut($faker->dateTimeBetween('-5 years', 'now'));
            $voyage->setDateFin($faker->dateTimeBetween($voyage->getDateDebut(), '+ 20 days'));
            $voyage->setDescription($faker->text);
            $voyage->setDatePublication($faker->dateTimeBetween($voyage->getDateDebut(), $voyage->getDateFin()));
            $voyage->setIsPublic(true);
            $voyage->setPhoto($faker->imageUrl());
            $voyage->setPriorite(1);
            $voyage->setUserId($userTest);
            $voyage->setNbPersonnes($faker->numberBetween(1, 50));
            $manager->persist($voyage);

            for ($e = 0; $e < $faker->numberBetween(3, 10); $e++) {
                $etape = new Etape();
                $etape->setName($faker->text(15));
                $etape->setDescription($faker->text);
                $etape->setBudget($faker->numberBetween(10, 200));

                $etape->setDateDebut($this->dateModify($voyage->getDateDebut(), $e));
                $etape->setDateFin($this->dateModify($voyage->getDateDebut(), $e += 1));
                $etape->setPays($faker->country);
                $etape->setCoordinates([$faker->latitude, $faker->longitude]);
                $etape->setVille($faker->city);
                $etape->setPhoto($faker->imageUrl());
                $etape->setVoyageId($voyage);
                $manager->persist($etape);

                for ($a = 0; $a < $faker->numberBetween(1, 3); $a++) {
                    $activite = new Activite();
                    $activite->setNom($faker->text(15));
                    $activite->setDescription($faker->text);

                    $dateActivite = $this->dateModify($etape->getDateDebut(), $a);

                    $activite->setDateDebut($dateActivite);
                    $activite->setDateFin($dateActivite);
                    $activite->setEtapeId($etape);
                    $activite->setCoordinates([$faker->latitude, $faker->longitude]);
                    $activite->setTypeTransport('voiture');

                    $photos = [
                        $faker->imageUrl(),
                        $faker->imageUrl(),
                        $faker->imageUrl(),
                    ];
                    $activite->setPhoto($photos);

                    $manager->persist($activite);
                }

                foreach ($users as $user) {
                    $user->addUser($userTest);
                    $commentaire = new Commentaires();
                    $commentaire->setVoyageId($voyage);
                    $commentaire->setUserId($user);
                    $commentaire->setDatePublication(new \DateTime('now'));
                    $commentaire->setMessage($faker->text);
                    $manager->persist($commentaire);
                }
            }
            $userTest->addVoyagesSuivi($voyage);
        }

        $userTest->addUser($userAdmin);

        $manager->flush();
    }

    public function dateModify($date, $increment)
    {
        $newDate = new \DateTime();
        $newDate->setTimestamp($date->getTimestamp());
        $modify = "+" . $increment . " days";
        return $newDate->modify($modify);
    }
}
