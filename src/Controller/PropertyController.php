<?php
namespace App\Controller;

use App\Entity\Property;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\PropertyRepository;
use Doctrine\Common\Persistence\ObjectManager;

class PropertyController extends AbstractController
{
    private $repository;

    public function __construct(PropertyRepository $repository, ObjectManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }
    /**
     *
     * @Route("/biens", name="property.index")
     * @return Response
     *
     */
    public function index(): Response
    {
        return $this->render("property/index.html.twig", [
            'current_menu' => 'properties'
        ]);
    }

    /**
     *
     * @Route("/biens/{slug}-{id}", name="property.show", requirements={"slug": "[a-z0-9\-]*"})
     * @return Response;
     */
    public function show(Property $property, string $slug)
    {
        if ($property->getSlug() !== $slug) {
            $this->redirectToRoute('property.show', [
                'id' => $property->getId(),
                'slug' => $property->getSlug()
            ], 301);
        }
        return $this->render("property/show.html.twig", [
            'property' => $property,
            'current_menu' => 'properties'
        ]);
    }
}
