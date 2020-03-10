<?php

namespace App\Controller;

use App\Form\FindType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class FindController extends AbstractController
{
    /**
     * @Route("/find", name="find_items")
     */
    public function index()
    {
        $form = $this->createForm(FindType::class);

        return $this->render('find/index.html.twig', [
            'controller_name' => 'FindController',
            'form' => $form->createView(),
        ]);
    }
}
