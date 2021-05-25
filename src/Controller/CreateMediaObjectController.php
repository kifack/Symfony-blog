<?php
namespace App\Controller;
use ApiPlatform\Core\Bridge\Symfony\Validator\Exception\ValidationException;
use App\Entity\MediaObject;
use App\Form\MediaObjectType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class CreateMediaObjectController extends AbstractController
{
    private $validator;
    private $doctrine;
    private $factory;

    public function __construct( FormFactoryInterface $factory, ValidatorInterface $validator)
    {
        $this->validator = $validator;
        $this->factory   = $factory;
    }

    /**
     * @param Request $request
     * @Route("media_objects", name="media")
     *
     * @return MediaObject
     */
    public function mediaCreation(Request $request): MediaObject
    {
        $mediaObject = new MediaObject();

        $form = $this->factory->create(MediaObjectType::class, $mediaObject);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($mediaObject);
            $em->flush();

            // Prevent the serialization of the file property
            $mediaObject->file = null;

            return $mediaObject;
        }

        // This will be handled by API Platform and returns a validation error.
        throw new ValidationException($this->validator->validate($mediaObject));


        // https://stackoverflow.com/questions/59070612/symfony-4-3-api-platform-with-vich-bundle-how-to-multiple-file-upload
    }
}