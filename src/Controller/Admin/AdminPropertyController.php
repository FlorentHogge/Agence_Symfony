<?php

namespace App\Controller\Admin;

use App\Entity\Property;
use App\Form\PropertyType;

use App\Repository\PropertyRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminPropertyController extends AbstractController
{

    private $repository;

    public function __construct(PropertyRepository $repository, ObjectManager $manager){
        $this->repository = $repository;
        $this->manager = $manager;
    }

    /**
     * @Route("/admin", name="admin_property")
     */
    public function index()
    {
        $properties = $this->repository->findAll();
        return $this->render('admin/admin_property/index.html.twig', compact('properties'));

    }

    /**
     * @Route("/admin/property/new", name="admin_property_new")
     */
    public function new(Request $request){
        $property = new Property();
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            $this->manager->persist($property);
            $this->manager->flush();
            $this->addFlash('success', 'Le bien a été ajouté.');
            return $this->redirectToRoute('admin_property');
        }

        return $this->render('admin/admin_property/new.html.twig', [
            'property' => $property,
            'form' =>$form->createView()
        ]);

    }

    /**
     * @Route("/admin/property/{id}", name="admin_property_edit", methods="GET|POST")
     */
    public function edit(Property $property, Request $request){
        $form = $this->createForm(PropertyType::class, $property);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $this->manager->flush();
            $this->addFlash('success', 'Le bien a été modifié avec succès.');
            return $this->redirectToRoute('admin_property');
        }

        return $this->render('admin/admin_property/edit.html.twig', [
            'property' => $property,
            'form' =>$form->createView()
        ]);
    }

    /**
     * @Route("/admin/property/{id}", name="admin_property_delete", methods="DELETE")
     */
    public function delete(Property $property, Request $request){

        if($this->isCsrfTokenValid('delete'. $property->getId(), $request->get('_token'))){
            
            $this->manager->remove($property);
            $this->manager->flush();

            $this->addFlash('success', 'Le bien a été supprimé.');
        }

        return $this->redirectToRoute('admin_property');
    }

}
