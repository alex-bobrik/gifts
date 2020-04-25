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
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ItemController extends AbstractController
{
    /**
     * @Route("/admin/items", name="admin_items")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function index()
    {
        $items = $this->getDoctrine()->getRepository(Item::class)->findAll();

        return $this->render('item/index.html.twig', [
            'controller_name' => 'ItemController',
            'items' => $items,
        ]);
    }

    /**
     * @Route("/admin/items/{id}", name="admin_item_info", requirements={"id"="\d+"})
     * @param int $id
     * @return RedirectResponse|Response
     */
    public function itemInfo(int $id)
    {
        /** @var Item $item */
        $item = $this->getDoctrine()->getRepository(Item::class)->find($id);

        return $this->render('item/info.html.twig', [
            'controller_name' => 'ItemController',
            'item' => $item,
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
        if ($form->isSubmitted() && $form->isValid()) {

            $item = $form->getData();
            $file = new UploadedFile($form->get('image')->getData(), 'file');

            $date = new \DateTime('now');
            $date = $date->format('m-d-Y_H-i-m');
            $fileName = $file->getFileName() . '_' . $date . '.' . $file->guessExtension();

            $file->move(
                $this->getParameter('files_directory'),
                $fileName
            );

            $item->setImage($fileName);

            $itemService->saveItem($item);

            return $this->redirectToRoute('admin_item_info', ['id' => $item->getId()]);
        }

        return $this->render('item/new.html.twig', [
            'controller_name' => 'ItemController',
            'form' => $form->createView(),
        ]);
    }

//    /**
//     * @Route("/admin/items/edit/{id}", name="admin_items_edit")
//     * @param Request $request
//     * @param ItemService $itemService
//     * @param int $id
//     * @return Response
//     */
//    public function editItem(Request $request, ItemService $itemService, int $id)
//    {
//        $item = $this->getDoctrine()->getRepository(Item::class)->find($id);
//
//        $form = $this->createForm(ItemType::class, $item);
//
//        $form->handleRequest($request);
//        if ($form->isSubmitted()) {
//            $item = $form->getData();
//            $itemService->saveItem($item);
//
//            return $this->redirectToRoute('admin_item_info', ['id' => $item->getId()]);
//        }
//
//        return $this->render('item/edit.html.twig', [
//            'controller_name' => 'ItemController',
//            'form' => $form->createView(),
//        ]);
//    }

    /**
     * @Route("/admin/items/delete/{id}", name="admin_items_delete")
     * @param ItemService $itemService
     * @param int $id
     * @return Response
     */
    public function deleteItem(ItemService $itemService, int $id)
    {
        $itemService->deleteItemById($id);
        return $this->redirectToRoute('admin_items');
    }
}
