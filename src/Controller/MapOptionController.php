<?php

namespace App\Controller;

use App\Entity\MapOption;
use App\Form\Item\MapOptionType;
use App\Service\MapOptionService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MapOptionController extends AbstractController
{
    /**
     * @Route("/admin/map-options", name="admin_mapOptions")
     */
    public function index()
    {
        $mapOptions = $this->getDoctrine()->getRepository(MapOption::class)->findAll();

        return $this->render('map_option/index.html.twig', [
            'controller_name' => 'MapOptionController',
            'mapOptions' => $mapOptions,
        ]);
    }

    /**
     * @Route("/admin/map-options/new", name="admin_mapOption_new")
     * @param Request $request
     * @param MapOptionService $mapOptionService
     * @return Response
     */
    public function newMapOption(Request $request, MapOptionService $mapOptionService)
    {
        $mapOption = new MapOption();

        $form = $this->createForm(MapOptionType::class, $mapOption);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $mapOption = $form->getData();
            $mapOptionService->saveMapOption($mapOption);

            return $this->redirectToRoute('admin_mapOptions');
        }

        return $this->render('map_option/new.html.twig', [
            'controller_name' => 'MapOptionController',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/map-options/edit/{id}", name="admin_mapOption_edit")
     * @param Request $request
     * @param MapOptionService $mapOptionService
     * @param int $id
     * @return Response
     */
    public function editMapOption(Request $request, MapOptionService $mapOptionService, int $id)
    {
        $mapOption = $this->getDoctrine()->getRepository(MapOption::class)->find($id);

        $form = $this->createForm(MapOptionType::class, $mapOption);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $mapOption = $form->getData();
            $mapOptionService->saveMapOption($mapOption);

            return $this->redirectToRoute('admin_mapOptions');
        }

        return $this->render('map_option/edit.html.twig', [
            'controller_name' => 'MapOptionController',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/map-options/delete/{id}", name="admin_mapOption_delete")
     * @param Request $request
     * @param MapOptionService $mapOptionService
     * @param int $id
     * @return Response
     */
    public function deleteMapOption(MapOptionService $mapOptionService, int $id)
    {
       $mapOptionService->deleteMapOptionById($id);

       return $this->redirectToRoute('admin_mapOptions');
    }
}
