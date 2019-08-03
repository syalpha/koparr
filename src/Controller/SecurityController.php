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
        if (isset($values->username,$values->password,$values->nom,$values->prenom,$values->adresse,$values->telephone)) 
        {

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

    /**
    * @Route("/ajoutcaissier")
    */

    public function addcaisse(Request $request, EntityManagerInterface $entityManagerInterface, UserPasswordEncoderInterface $passwordEncoder)
    {
        $values= json_decode($request->getContent());
        if (isset($values->username,$values->password,$values->prenom,$values->nom,$values->telephone,$values->adresse)) {
            $user =new User();
            $user->setPrenom($values->prenom);
            $user->setNom($values->nom);
            $user->setAdresse($values->adresse);
            $user->setTelephone($values->telephone);
            $user->setUsername($values->username);
            $user->setPassword($passwordEncoder->encodePassword($user, $values->password));
            $user->setRoles(['ROLE_CAISSIER']);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            $data = [
                    'status' => 201,
                    'message' => 'CAISSIER CREE'
                ];
            return new JsonResponse($data, 201);
        }
        $data = [
            'status' => 500,
            'message' => 'VERIFIER LES INFORMATION SAISIE'
        ];
        return new JsonResponse($data, 500);
    }
}
