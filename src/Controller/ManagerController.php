<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ManagerController extends AbstractController
{
    /**
     * @Route("/manager", name="manager")
     */
    public function index()
    {
        return $this->render('manager/index.html.twig', [
            'controller_name' => 'ManagerController',
        ]);
    }

    /**
     * @Route("/manager/orders", name="manager_orders")
     */
    public function orders()
    {
        return $this->render('manager/orders.html.twig', [
            'controller_name' => 'ManagerController',
        ]);
    }
}
