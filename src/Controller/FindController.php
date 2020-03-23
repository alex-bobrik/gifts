<?php

namespace App\Controller;

use App\Entity\Item;
use App\Entity\MapOption;
use App\Entity\TagKind;
use App\Form\FindType;
use App\Service\ItemService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class FindController extends AbstractController
{
    /**
     * @Route("/find", name="find")
     */
    public function index(Request $request, ItemService $itemService)
    {
        $form = $this->createForm(FindType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $info = $form->getData();

            $result = $itemService->getSelectedTags($info);

            $items = $itemService->findItemsByTags($result);

            return $this->render('find/result.html.twig', [
                'controller_name' => 'FindController',
                'items' => $items,
            ]);

        }

        return $this->render('find/index.html.twig', [
            'controller_name' => 'FindController',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/find/map/{id}", name="find_map", requirements={"id"="\d+"})
     */
    public function showItemOnMap(int $id)
    {
        $mapOption = $this->getDoctrine()->getRepository(MapOption::class)->find($id);

        return $this->render('find/map.html.twig', [
            'controller_name' => 'FindController',
            'mapOption' => $mapOption,
        ]);
    }
}
