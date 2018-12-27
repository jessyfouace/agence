<?php
namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\PropertyRepository;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Property;
use Symfony\Component\HttpFoundation\Response;
use App\Form\PropertyType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;

class AdminPropertyController extends AbstractController
{
    private $repository;

    public function __construct(PropertyRepository $repository, ObjectManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/admin", name="admin.property.index")
     *
     * @return void
     */
    public function index()
    {
        $properties = $this->repository->findAll();
        return $this->render('admin/property/index.html.twig', compact('properties'));
    }

    /**
     * @Route("/admin/{id}", name="admin.property.edit")
     *
     * @return void
     */
    public function edit(Property $property, Request $request)
    {
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            return $this->redirectToRoute('admin.property.index');
        }
        return $this->render('admin/property/edit.html.twig', [
            'property' => $property,
            'form' => $form->createView()
        ]);
    }
}
