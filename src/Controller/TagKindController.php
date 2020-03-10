<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TagKindController extends AbstractController
{
    /**
     * @Route("/admin/tag-kind", name="admin_tagKind")
     */
    public function index()
    {
        return $this->render('tag_kind/index.html.twig', [
            'controller_name' => 'TagKindController',
        ]);
    }
}
