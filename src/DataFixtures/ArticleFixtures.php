<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Category;
use App\Entity\Article;
use App\DataFixtures\CatgoryFixtures;
use App\DataFixtures\UserFixtures;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;


class ArticleFixtures extends Fixture implements DependentFixtureInterface
{
	public function getDependencies()
	{
		return [
			CatgoryFixtures::class,UserFixtures::class
		];
	}
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $state=["wait-review","published"];
          $faker = \Faker\Factory::create('fr_FR');
        for($i=0;$i<8;$i++) {
        	
        	    $article= new Article;
                
                $article->setName($faker->words(3,true))
                         ->setDescription($faker->paragraphs(4,true))
                         ->setPrice($faker->randomFloat(2,0,999))
                         ->setState($state[mt_rand(0,1)])
                         ->setCategory($this->getReference("CAT".mt_rand(1,5)))
                         ->setAuthor($this->getReference("USER".mt_rand(3,5)))
                         ->setCreatedAt($faker->dateTimeBetween("-6 months"));
                $manager->persist($article);
                $this->addReference("ART".$i,$article);
        }

        $manager->flush();

  
    }
}
