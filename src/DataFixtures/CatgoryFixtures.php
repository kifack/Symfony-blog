<?php

namespace App\DataFixtures;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CatgoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
          $faker = \Faker\Factory::create('fr_FR');
        for($i=1;$i<6;$i++) {
        	
        	$category = new Category;
        	$category->setName($faker->words(3,true));


        	$manager->persist($category);

        	$this->addReference("CAT".$i,$category);

        }
        $manager->flush();
    }
}
