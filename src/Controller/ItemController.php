<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ItemController extends AbstractController
{
    /**
     * @Route("/admin/items", name="admin_items")
     */
    public function index()
    {
        return $this->render('item/index.html.twig', [
            'controller_name' => 'ItemController',
        ]);
    }

    /**
     * @Route("/admin/items/new", name="admin_items_new")
     */
    public function newItem()
    {
        return $this->render('item/index.html.twig', [
            'controller_name' => 'ItemController',
        ]);
    }

    /**
     * @Route("/admin/items/edit/{id}", name="admin_items_edit")
     * @param int $id
     * @return Response
     */
    public function editItem(int $id)
    {
        return $this->render('item/index.html.twig', [
            'controller_name' => 'ItemController',
        ]);
    }
}
