<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        return $this->redirectToRoute('find');

    }

    /**
     * @Route("/about-us", name="about")
     */
    public function about()
    {
        return $this->render('home/about.html.twig');
    }
}
