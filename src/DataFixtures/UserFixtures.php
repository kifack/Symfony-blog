<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
class UserFixtures extends Fixture
{
	 public function __construct(UserPasswordEncoderInterface $encoder)
	 {
	 	$this->passwordEncoder=$encoder;
	 }
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
       $count=0;
        $info= [
        	'user1@gmail.com' => [],
        	'user2@gmail.com' => [],
        	'user3@gmail.com' => ["ROLE_AUTHOR"],
        	'user4@gmail.com' => ["ROLE_ADMIN"],
        	'user5@gmail.com' => ["ROLE_AUTHOR"],
        ];
          $faker =  \Faker\Factory::create('fr_FR');
        foreach ($info as $email => $role) {
        	$user= new User;
            $count++;
        	$user->setFirstName($faker->firstName());
        	$user->setLastName($faker->lastName());
        	$user->setEmail($email);
        	$hash= $this->passwordEncoder->encodePassword($user,"password123");
        	$user->setPassword($hash);
        	$user->setRoles($role);

        	$manager->persist($user);
            $this->addReference("USER".$count,$user);


        }

        $manager->flush();
    }
}
