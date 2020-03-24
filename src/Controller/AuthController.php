<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;


/**
 * @Route("/api")
 */
class AuthController extends AbstractController
{
    /**
     * @Route("/register", name="register", methods={"POST"})
     */
    public function register(Request $request, UserPasswordEncoderInterface
    $passwordEncoder, EntityManagerInterface $entityManager,
                             SerializerInterface $serializer, ValidatorInterface $validator)
    {
        $values = json_decode($request->getContent());
        if(isset($values->email,$values->password)) {
            $user = new User();
            $user->setEmail($values->email);
            $user->setPassword($passwordEncoder->encodePassword($user,
                $values->password));
            $user->setRoles($user->getRoles());
            $user->setDateCreation(new \DateTime());
            $user->setNom($values->nom);
            $user->setPrenom($values->prenom);
            $user->setAge($values->age);
            $errors = $validator->validate($user);
            if(count($errors)) {
                $errors = $serializer->serialize($errors, 'json');
                return new Response($errors, 500, [
                    'Content-Type' => 'application/json'
                ]);
            }
            $entityManager->persist($user);
            $entityManager->flush();

            $data = [
                'status' => 201,
                'message' => 'L\'utilisateur a été créé',
                "userId" => $user->getId()
            ];

            return new JsonResponse($data, 201);
        }
        $data = [
            'status' => 500,
            'message' => 'Vous devez renseigner les clés email et
password'
        ];
        return new JsonResponse($data, 500);
    }

    /**
     * @Route("/login", name="login", methods={"POST"})
     */
    public function login(Request $request, UserRepository $repository, UserPasswordEncoderInterface
    $passwordEncoder)
    {
        
        $req = json_decode($request->getContent());
        $user = $repository->findOneByMail($req->email);
        if ($this->checkCredentials($req, $user, $passwordEncoder))
            return $this->json([
                'id' => $user->getId(),
                'email' => $user->getEmail(),
                'roles' => $user->getRoles()
            ]);
        else return $this->json([
            'error' => 'credentials error'
        ]);

    }

    public function checkCredentials($credentials, $user, UserPasswordEncoderInterface
    $passwordEncoder)
    {
        return $passwordEncoder->isPasswordValid($user, $credentials->password);
    }
}