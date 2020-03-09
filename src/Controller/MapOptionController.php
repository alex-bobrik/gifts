<?php

namespace App\Controller;

use App\Entity\MapOption;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
}
