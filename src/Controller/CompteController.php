<?php

namespace App\Controller;

use App\Entity\Compte;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\Entreprise;
use App\Entity\User;

class CompteController extends AbstractController
{
    /**
     * @Route("/compte", name="compte")
     */
    
    public function compte(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder)
    {

        $values= json_decode($request->getContent());

       /*  if (isset($values->username,$values->password,$values->prenom,$values->nom,$values->telephone,$values->adresse,$values->cni)) {
            $user =new User();
            $user->setPrenom($values->prenom);
            $user->setNom($values->nom);
            $user->setCNI($values->cni);
            $user->setAdresse($values->adresse);
            $user->setTelephone($values->telephone);
            $user->setUsername($values->username);
            $user->setPassword($passwordEncoder->encodePassword($user, $values->password));
            $user->setRoles(['ROLE_CAISSIER']);
            
            $entityManager = $this->getDoctrine()->getManager();
            $utili=$this->getDoctrine()->getRepository(Compte::class)->find(1);

            $user->setIdentreprise($utili);
            $entityManager->persist($user);
            $entityManager->persist($utili);
            $entityManager->flush(); */

            $compte = new compte();
            $jour = date('d');
            $mois = date('m');
            $annee = date('Y');
            $heure = date('H');
            $minute = date('i');
            $seconde = date('s');
            $generer = $jour.$mois.$annee.$heure.$minute.$seconde;
            if (isset($generer)) {
                $compte->setNumcompte($generer);
                $compte->setSolde(75000);
                
                $entreprise=$this->getDoctrine()->getRepository(Entreprise::class)->find(1);
                
                $compte->setIdentreprise($entreprise);
                $entityManager->persist($compte);
                $entityManager->persist($entreprise); 
                $entityManager->flush();
                
                
                $data = [
                        'status' => 201,
                        'message' => 'NICE'
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