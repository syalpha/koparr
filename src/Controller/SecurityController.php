<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\Entreprise;

/**
 * @Route("/api")
 */
class SecurityController extends AbstractController
{
    /**
     * @Route("/register", name="register", methods={"POST"})
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $entityManager)
    {
        $values = json_decode($request->getContent());
        if (isset($values->username,$values->password,$values->nom,$values->prenom,$values->adresse,$values->telephone)) {
            /* $entreprise = new Entreprise(); */
            $user = new User();
            $user->setUsername($values->username);
            $user->setNom($values->nom);
            $user->setPrenom($values->prenom);
            $user->setAdresse($values->adresse);
            $user->setTelephone($values->telephone);
            $user->setPassword($passwordEncoder->encodePassword($user, $values->password));
            $user->setRoles(['ROLES_ADMIN']);

            $entrepris=$this->getDoctrine()->getRepository(Entreprise::class)->find(1);
            
            
            $user->setIdentreprise($entrepris);
            $entityManager->persist($user);
            $entityManager->persist($entrepris);
            $entityManager->flush();
            
            $data = [
                'status' => 201,
                'message' => 'L\'utilisateur a été créé'
            ];
            
            return new JsonResponse($data, 201);
        }
        $data = [
            'status' => 500,
            'message' => 'Vous devez renseigner les clés username et password'
        ];
        return new JsonResponse($data, 500);
    }

     /**
     * @Route("/login", name="login", methods={"POST"})
     */

    public function login(Request $request)
    {
        $user = $this->getUser();
        return $this->json([
            'username' => $user->getUsername(),
            'roles' => $user->getRoles()
        ]);
    }
}