<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Utilisateur;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminFixtures extends Fixture
{

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;  
    }

    public function load(ObjectManager $manager)
    {
         $utilisateur = new Utilisateur();

         $utilisateur->setNom('SY');
         $utilisateur->setPrenom('Alpha');
         $utilisateur->setEmail('papa@gmail.com');
         $utilisateur->setRoles(['ROLES_ADMIN']);
         $password = $this->encoder->encodePassword($utilisateur,'hello');
         $utilisateur->setPassword($password);
         
         $manager->persist($utilisateur);

        $manager->flush();

    }
    
}
