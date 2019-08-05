<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Transaction;
use App\Entity\Compte;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Flex\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Proxies\__CG__\App\Entity\Entreprise;

class TransactionController extends AbstractController
{ 
     /**
     * @Route("/transaction")
     */
      public function transac(Request $request,EntityManagerInterface $entityManager)
    { 
        $values= json_decode($request->getContent());
        if (isset($values->montant)) {
    
            $trans= new Transaction();
             $compte= new Compte(); 

            $trans->setMontant($values->montant);
            $trans->setDatetrans(new \DateTime());

            $connect = $this->getUser();
            $connect->setIdentreprise($connect->get());

            /* $compte = $this->getDoctrine()->getRepository(Compte::class)->find(2); */
            $user = $this->getDoctrine()->getRepository(Entreprise::class)->find($connect->getIdentreprise());

            $compte->setSolde($compte->getSolde() + $values->montant);
            
           /*  $trans->getIdcompte($compte); */
            $trans->setIdentreprise($user);
            $entityManager->persist($trans);
            $entityManager->persist($compte);
            $entityManager->flush();
            /*  $entityManager->persist($user); */
           /*  $entityManager->persist($prest);
            $trans->setIdcompte($compte);
            $prest=$this->getDoctrine()->getRepository(User::class)->find(2);
            $trans->setIduser($prest);  */

            $rep = [
                'status' => 201,
                'message' => 'L\'utilisateur a été créé'
            ];

            return new JsonResponse('test');
        } 
    
    } 
}  