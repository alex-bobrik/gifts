<?php

namespace App\Controller;

use App\Entity\Item;
use App\Entity\MapOption;
use App\Entity\Tag;
use App\Form\ItemType;
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
        $item = new Item();
        $item->setName('Item 1');
        $item->setDescription('Item descr 1');
        $tag1 = new Tag();
        $tag2 = new Tag();
        $tag1->setName('Tag 1');
        $tag2->setName('Tag 2');
        $item->addTag($tag1);
        $item->addTag($tag2);
        $option = new MapOption();
        $option->setName('map 1');
        $item->addMapOption($option);

        $form = $this->createForm(ItemType::class, $item);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {

            $item = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($item);
            $em->flush();

            return $this->redirectToRoute('admin_items');
        }

        return $this->render('item/index.html.twig', [
            'controller_name' => 'ItemController',
            'form' => $form->createView(),
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
