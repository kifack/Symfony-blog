<?php

namespace App\Controller;

use App\Entity\Category;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\Validator\ValidatorInterface;
use ApiPlatform\Core\Validator\Exception\ValidationException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;


final class AddCategoryController extends AbstractController
{
   
    /**
     * @var ValidatorInterface
     */
    private $validator;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(
        ValidatorInterface $validator,
        EntityManagerInterface $entityManager
    )
    {
        $this->validator = $validator;
        $this->entityManager = $entityManager;

    }

    public function __invoke(Request $request):Activity
    {
       
        $category=new Category();

        $category->setName($request->request->get('name') || "");
          
        $this->validator->validate($category);

        $this->entityManager->persist($category);
        
       // $this->entityManager->flush();
        return $category;
    }
}

http://jameshuynh.com/rails/react/upload/2017/09/17/how-to-upload-files-using-react-and-rails-like-a-boss/