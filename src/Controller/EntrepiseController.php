<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Entreprise;

class EntrepiseController extends AbstractController
{
   /**
     * @Route("/addentreprise", name="entreprise")
     */
    public function add(Request $request, EntityManagerInterface $entityManagerInterface,UserPasswordEncoderInterface $passwordEncoder)
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
    
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($entreprise);
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
