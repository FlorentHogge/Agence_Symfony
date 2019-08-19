<?php

namespace App\Controller;

use App\Entity\Property;
use App\Entity\PropertySearch;
use App\Form\PropertySearchType;
use App\Repository\PropertyRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PropertyController extends AbstractController
{
    /**
     * @Route("/acheter", name="store")
     */
    public function index(PropertyRepository $repository, ObjectManager $manager, PaginatorInterface $paginator, Request $request)
    {
        $search = new PropertySearch();

        $form = $this->createForm(PropertySearchType::class, $search);
        $form->handleRequest($request);
        
        $properties = $paginator->paginate($repository->findAllVisibleQuery($search), 
                                            $request->query->getInt('page', 1), 12);

        return $this->render('property/buy.html.twig', [
            'current_menu' => 'store',
            'properties' => $properties,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/acheter/{slug}-{id}", name="show", requirements={"slug": "[a-z0-9\-]*"})
     */
    public function show(Property $property, string $slug, PropertyRepository $repository){

        if($property->getSlug() != $slug){
            return $this->redirectToRoute('show', [
                'id' => $property->getId(),
                'slug' => $property->getSlug()
            ], 301);
        }

        return $this->render('property/show.html.twig', [
            'property' => $property,
            'current_menu' => 'store'
        ]);
    }
}
