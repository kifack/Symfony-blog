<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategoryRepository;
use App\Entity\Article;
class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(CategoryRepository $repository)
    {
         $categories = $repository->findAllCategoryPublished();
        //  dump($query);
        return $this->render('default/index.html.twig', [
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/read/{id}", name="read")
     */
    public function read(Article $article)
    {   
    	if ($article->getState() != "published") {
    		
    		return $this->redirectToRoute('home');
    	}
        return $this->render('default/read.html.twig', [
            'article' => $article
        ]);
    }
}
