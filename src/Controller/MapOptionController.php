<?php

namespace App\Controller;

use App\Entity\MapOption;
use App\Form\Item\MapOptionType;
use App\Form\SearchType;
use App\Service\MapOptionService;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;

class MapOptionController extends AbstractController
{
    /**
     * @Route("/admin/map-options", name="admin_mapOptions")
     */
    public function index(PaginatorInterface $paginator, Request $request, RouterInterface $router)
    {
//        $mapOptions = $this->getDoctrine()->getRepository(MapOption::class)->findAll();

        $mapsRepo = $this->getDoctrine()->getRepository(MapOption::class);

        $q = $request->get('s');

        if ($q) {
            $mapQuery = $mapsRepo->createQueryBuilder('m')
                ->select('m')
                ->where('m.name like :name')
                ->setParameter('name', '%'.$q.'%')
                ->getQuery();
        } else {
            $mapQuery = $mapsRepo->createQueryBuilder('m')
                ->getQuery();
        }

        $form = $this->createForm(SearchType::class, ['query' => $q]);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $search = $form->get('query')->getData();

            return new RedirectResponse($router->generate('admin_mapOptions', ['s' => $search]));
        }

        $mapOptions = $paginator->paginate(
            $mapQuery,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('map_option/index.html.twig', [
            'controller_name' => 'MapOptionController',
            'mapOptions' => $mapOptions,
            'form' => $form->createView(),
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
    public function deleteMapOption(MapOptionService $mapOptionService, int $id, EntityManagerInterface $em)
    {
       $mapOption = $this->getDoctrine()->getRepository(MapOption::class)->find($id);

        try {
            $em->remove($mapOption);
            $em->flush();
        } catch (ForeignKeyConstraintViolationException $ex) {
            $this->addFlash('danger', 'Нельзя удалить метку, есть связи с подарками');

            return $this->redirectToRoute('admin_mapOptions');
        }

        $this->addFlash('info', 'Метка удалена');


        return $this->redirectToRoute('admin_mapOptions');
    }
}
