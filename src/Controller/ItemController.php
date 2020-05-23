<?php

namespace App\Controller;

use App\Entity\Item;
use App\Entity\MapOption;
use App\Entity\Tag;
use App\Form\Item\ItemType;
use App\Form\SearchType;
use App\Service\ItemService;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;

class ItemController extends AbstractController
{
    /**
     * @Route("/admin/items", name="admin_items")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function index(PaginatorInterface $paginator, Request $request, RouterInterface $router)
    {

        $itemsRepo = $this->getDoctrine()->getRepository(Item::class);
        $q = $request->get('s');


        if ($q) {
            $itemQuery = $itemsRepo->createQueryBuilder('i')
                ->select('i')
                ->where('i.name like :name')
                ->setParameter('name', '%'.$q.'%')
                ->getQuery();
        } else {
            $itemQuery = $itemsRepo->createQueryBuilder('i')
                ->getQuery();
        }

        $form = $this->createForm(SearchType::class, ['query' => $q]);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $search = $form->get('query')->getData();

            return new RedirectResponse($router->generate('admin_items', ['s' => $search]));
        }

        $items = $paginator->paginate(
            $itemQuery,
            $request->query->getInt('page', 1),
            7
        );

        return $this->render('item/index.html.twig', [
            'controller_name' => 'ItemController',
            'items' => $items,
            'form' => $form->createView(),
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

            return $this->redirectToRoute('admin_items');
        }

        return $this->render('item/new.html.twig', [
            'controller_name' => 'ItemController',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/items/delete/{id}", name="admin_items_delete")
     * @param ItemService $itemService
     * @param int $id
     * @return Response
     */
    public function deleteItem(ItemService $itemService, int $id, EntityManagerInterface $em)
    {
        $item = $this->getDoctrine()->getRepository(Item::class)->find($id);

        try {
            $em->remove($item);
            $em->flush();
        } catch (ForeignKeyConstraintViolationException $ex) {
            $this->addFlash('danger', 'Нельзя удалить подарок, есть связи');
        }

        return $this->redirectToRoute('admin_items');
    }
}
