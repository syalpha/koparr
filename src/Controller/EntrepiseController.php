<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Entreprise;
use App\Entity\User;
use App\Entity\Compte;

class EntrepiseController extends AbstractController
{

    /**
      * @Route("/addentrepr", name="entreprise")
      * 
      */
      public function addpart(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder)
    {
        $values= json_decode($request->getContent());
        if (isset($values->nomentreprise,$values->ninea,$values->adresse,$values->telephone,$values->numregistre,$values->email)) 
        {

            $entreprise =new Entreprise();
            $entreprise->setNomentreprise($values->nomentreprise);
            $entreprise->setNinea($values->ninea);
            $entreprise->setAdresse($values->adresse);
            $entreprise->setEmail($values->email);
            $entreprise->setStatut('ACTIF');
            $entreprise->setNumregistre($values->numregistre);
            $entreprise->setTelephone($values->telephone);

            $rep = [
                'statut' => 201,
                'release' => 'L\'utilisateur a été créé'
            ];
            
        return new JsonResponse($rep, 201);
    }
    $data = [
            'marque' => 500,
            'parti' => 'Vous devez renseigner les champs'
        ];
    return new JsonResponse($data, 500);
}


    /**
      * @Route("/addentreprise", name="entreprise")
      * 
      */
    public function add(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder)
    {
        $values= json_decode($request->getContent());
        if (isset($values->nomentreprise,$values->ninea,$values->adresse,$values->telephone,$values->numregistre,$values->email)) 
        {

            $entreprise =new Entreprise();
            $entreprise->setNomentreprise($values->nomentreprise);
            $entreprise->setNinea($values->ninea);
            $entreprise->setAdresse($values->adresse);
            $entreprise->setEmail($values->email);
            $entreprise->setStatut('ACTIF');
            $entreprise->setNumregistre($values->numregistre);
            $entreprise->setTelephone($values->telephone);

            $user = new User();
            $user->setUsername($values->username);
            $user->setNom($values->nom);
            $user->setPrenom($values->prenom);
            $user->setCNI($values->cni);
            $user->setAdresse($values->adresses);
            $user->setTelephone($values->telephones);
            $user->setPassword($passwordEncoder->encodePassword($user, $values->password));
            $user->setRoles(['ROLES_ADMIN_PARTENAIRE']);

            $numcompte = date('y').date('m').date('d').date('H').date('i').date('s');
            $compte = new compte();
            $compte->setNumcompte($numcompte);
            $compte->setSolde(0);

            /*     $entreprise->setIdentreprise($entreprise) */
    
            /* $entrepris=$this->getDoctrine()->getRepository(Entreprise::class)->find(1) */;
            $user->setIdentreprise($entreprise);
            $compte->setIdentreprise($entreprise);
                
            $entityManager->persist($user);
            $entityManager->persist($compte);
            $entityManager->persist($entreprise);
            $entityManager->flush();
                
            $rep = [
                    'action' => 201,
                    'prepare' => 'L\'utilisateur a été créé'
                ];
                
            return new JsonResponse($rep, 201);
        }
        $data = [
                'action' => 500,
                'prepare' => 'Vous devez renseigner les champs'
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
            
            public function addcaisse(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder)
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
                    $rep = [
                        'status' => 201,
                        'message' => 'PRESTATAIRE CREER'
                ];
                return new JsonResponse($rep, 201);
            }
            
            $rep = [
                'status' => 500,
                'message' => 'AJOUT PAS REUSSIT'
            ];
            return new JsonResponse($rep, 500);
            
        }
    }                

    
    
    
