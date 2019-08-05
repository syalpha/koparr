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
use App\Repository\EntrepriseRepository;

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
        if (isset($values->username,$values->password,$values->nom,$values->prenom,$values->adresse,$values->telephone,$values->cni)) 
        {

            $user = new User();
            $user->setUsername($values->username);
            $user->setNom($values->nom);
            $user->setPrenom($values->prenom);
            $user->setCNI($values->cni);
            $user->setAdresse($values->adresse);
            $user->setTelephone($values->telephone);
            $user->setPassword($passwordEncoder->encodePassword($user, $values->password));
            $user->setRoles(['ROLES_ADMIN']);

            $entrepris=$this->getDoctrine()->getRepository(Entreprise::class)->find(1);
            
            $user->setIdentreprise($entrepris);
            $entityManager->persist($user);
            $entityManager->persist($entrepris);
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

            $user=$this->getDoctrine()->getRepository(Entreprise::class)->find(1);
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

    
    /*
    * @Route("/{id}", name="prestataires_show", methods={"GET"})
    */
    public function show(EntrepriseRepository $Repository,$id )
    {
        $result = $Repository->find($id);
        $result = $this->get('serializer')->serialize($result,'json');
        $response = new Response($result);
        return($response);
        
    }
    /*
    * @Route("/{id}/edit", name="prestataires_edit", methods={"GET","POST"})
    */
    public function edit(Request $request,EntrepriseRepository $Repository,$id)
    {
        $values = $request->getContent();
        $values = json_decode($values, true);
        
        $entreprise = $Repository->find($id);
        
        $entreprise ->setNomentreprise($values-> nomentreprise);
        $entreprise ->setNinea($values-> ninea);
        $entreprise ->setNumregistre($values-> numregistre);
        $entreprise ->setAdresse($values-> adresse);
        $entreprise ->setEmail($values-> email);
        $entreprise ->setTelephone($values-> telephone);
        $entreprise ->setStatut('ACTIF');
        var_dump($entreprise);
        
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();
        
        $response = new Response("response edit");
        return($response);
    }
    
    /**
    * @Route("/{id}/block", name="entrprise_blk", methods={"GET","POST"})
    */
    public function block(entrepriseRepository $entrepriseRepository,$id)
    {
    
        $entreprise = $entrepriseRepository->find($id);
        $entreprise ->setStatut("blked");
    
        var_dump($entreprise);
        
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();
    
        $response = new Response("response");
        return($response);
    
    }
    /** 
     * @Route("/{id}/dblock", name="entreprise_dblk", methods={"GET","POST"})
     */
    public function dblock(entrepriseRepository $entrepriseRepository,$id)
    {
        
        $prestataire = $entrepriseRepository->find($id);
        $prestataire ->setStatut("dblked");
        
        var_dump($prestataire);
        
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();
        
        $response = new Response("response");
        return($response);
    
    }
}
