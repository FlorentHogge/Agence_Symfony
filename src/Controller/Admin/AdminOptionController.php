<?php

namespace App\Controller\Admin;

use App\Entity\Option;
use App\Form\OptionType;
use App\Repository\OptionRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin")
 */
class AdminOptionController extends AbstractController
{
    /**
     * @Route("/option", name="options")
     */
    public function index(OptionRepository $repository)
    {
        $options = $repository->findAll();
        return $this->render('admin/option/options.html.twig', [
            'options' => $options
        ]);
    }

    /**
     * @Route("/option/new", name="option_new")
     */
    public function new(Request $request, ObjectManager $manager){

        $option = new Option();
        $form = $this->createForm(OptionType::class, $option);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($option);
            $manager->flush();
            $this->addFlash('success', 'L\'option a été ajouté.');
            return $this->redirectToRoute('options');
        }

        return $this->render('admin/option/new.html.twig', [
            'option' => $option, 
            'form' => $form->createView() ]);
    }

    /**
     * @Route("/admin/otpion/{id}", name="option_edit", methods="GET|POST")
     */
    public function edit(Option $option, Request $request, ObjectManager $manager){
        $form = $this->createForm(OptionType::class, $option);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager->flush();
            $this->addFlash('success', 'L\'option a été renommée avec succès.');
            return $this->redirectToRoute('options');
        }

        return $this->render('admin/option/rename.html.twig', [
            'option' => $option,
            'form' =>$form->createView()
        ]);
    }

    /**
     * @Route("/admin/option/{id}", name="option_delete", methods="DELETE")
     */
    public function delete(Option $option, Request $request, ObjectManager $manager){

        if($this->isCsrfTokenValid('delete'. $option->getId(), $request->get('_token'))){
            
            $manager->remove($option);
            $manager->flush();

            $this->addFlash('success', 'Le bien a été supprimé.');
        }

        return $this->redirectToRoute('options');
    }

}
