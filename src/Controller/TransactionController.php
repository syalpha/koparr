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
            $trans->setMontant($values->montant);
            $trans->setDatetrans(new \DateTime());

            $compte = $this->getDoctrine()->getRepository(Compte::class)->find($values-> idcompte_id);

            $compte->setSolde($compte->getSolde() + $values->montant);
            
            $trans->setIdcompte($compte);
            $entityManager->persist($trans);
            $entityManager->flush();
           /*  $entityManager->persist($prest);
            $trans->setIdcompte($compte);
            $prest=$this->getDoctrine()->getRepository(User::class)->find(2);
            $trans->setIduser($prest);  */

            $rep = [
                'status' => 201,
                'message' => 'L\'utilisateur a été créé'
            ];

            return new JsonResponse('vbvbvb: '.$compte->getSolde());
        } 
    
    } 
}  