<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index()
    {
        return $this->redirectToRoute('admin_items');

    }

    /**
     * @Route("/manager", name="manager")
     */
    public function managerIndex()
    {
        return $this->redirectToRoute('manager_orders');
    }
}
