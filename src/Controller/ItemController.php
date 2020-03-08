<?php

namespace App\Controller;

use App\Entity\Item;
use App\Entity\MapOption;
use App\Entity\Tag;
use App\Form\Item\ItemType;
use App\Service\ItemService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ItemController extends AbstractController
{
    /**
     * @Route("/admin/items", name="admin_items")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function index(Request $request)
    {
        $items = $this->getDoctrine()->getRepository(Item::class)->findAll();

        return $this->render('item/index.html.twig', [
            'controller_name' => 'ItemController',
            'items' => $items,
        ]);
    }

    /**
     * @Route("/admin/items/new", name="admin_items_new")
     * @param Request $request
     * @param ItemService $itemService
     * @return Response
     */
    public function newItem(Request $request, ItemService $itemService)
    {
        $item = new Item();

        $form = $this->createForm(ItemType::class, $item);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {

            $item = $form->getData();
            $itemService->saveItem($item);

            return $this->redirectToRoute('admin_items');
        }

        return $this->render('item/new.html.twig', [
            'controller_name' => 'ItemController',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/items/edit/{id}", name="admin_items_edit")
     * @param EntityManagerInterface $em
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function editItem(EntityManagerInterface $em, Request $request, int $id)
    {
        $item = $this->getDoctrine()->getRepository(Item::class)->find($id);

        $form = $this->createForm(ItemType::class, $item);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $item = $form->getData();
            $em->flush();
        }

        return $this->render('item/index.html.twig', [
            'controller_name' => 'ItemController',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/items/delete", name="admin_items_delete")
     */
    public function deleteItem()
    {


        return $this->render('item/index.html.twig', [
            'controller_name' => 'ItemController',
        ]);
    }
}
