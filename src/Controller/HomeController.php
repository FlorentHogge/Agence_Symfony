<?php

namespace App\Controller;

use App\Repository\PropertyRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index(PropertyRepository $repository)
    {
        $properties = $repository->findLatest();

        return $this->render('home/home.html.twig', [
            'properties' => $properties
        ]);
    }
}
