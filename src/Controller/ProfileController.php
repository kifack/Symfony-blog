<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;
use App\Entity\Article;
use App\Repository\UserRepository;
use App\Form\UserType;

class ProfileController extends AbstractController
{
   

    /**
     * @IsGranted("ROLE_USER") 
     * @Route("/profile", name="update_profile", methods={"GET","POST"})
     */
    public function index(Request $request,UserPasswordEncoderInterface $encoder,UserRepository $repository): Response
    {    
        $user = $repository->find($this->getUser()->getId());
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        $this->denyAccessUnlessGranted('UPDATE_PROFILE', $user);

        if ($form->isSubmitted() && $form->isValid()) {

          if (!$this->emptyPassword($user)) {
              
              $isValid=$encoder->isPasswordValid($user,$user->getPasswordCurrent());
             if (!$isValid) {
               
                 $this->addFlash('error',"Wrong previous password");
                 return $this->redirect($request->headers->get('referer'));
             }

             $hash= $encoder->encodePassword($user
                       , $user->getPasswordUpdate());
             $user->setPassword($hash);
          }
        
            
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
             $this->addFlash('success',"profile modified successfully");
            return $this->redirectToRoute('article_index');
            
        }

        // dump($form->isSubmitted());
        // dump($form->isValid());

        return $this->render('profile/index.html.twig', [
            'form' => $form->createView(),
        ]);
        // return new Response('hello');
    }
    private function emptyPassword($user){

        if ($user->getPasswordCurrent()==="" && $user->getPasswordUpdate()==="") {
            return true;
        }

         if ($user->getPasswordCurrent()===null && $user->getPasswordUpdate()===null) {
            return true;
        }
        return false;
    }
}
