<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Component\HttpFoundation\Request;
use ApiPlatform\Core\Validator\ValidatorInterface;
use ApiPlatform\Core\Bridge\Symfony\Validator\Exception\ValidationException;
use Symfony\Component\Form\FormFactoryInterface;
use App\Form\ProductType;

final class ProductObject
{
   
   /**
     * @var FormFactoryInterface
     */
    private $formFactory;
    /**
     * @var ValidatorInterface
     */
   private $validator;
   public function __construct( FormFactoryInterface $formFactory,ValidatorInterface $validator)
{
    $this->validator = $validator;
    $this->formFactory = $formFactory;
}
    public function __invoke(Request $request): Product
    {
        $uploadedFile = $request->files->get('file');
        // dump($request);
        // if (!$uploadedFile) {
        //     throw new BadRequestHttpException('"file" is required');
        // }

        $product = new Product();
        // $form = $this->formFactory->create(ProductType::class, $product);
        // $form->handleRequest($request);
       
       
            $product->setImageFile($uploadedFile);
            $product->setDescription($request->request->get('description') || "");

            $this->validator->validate($product);
            return $product;
     

    }
}