<?php

namespace App\Controller;

use App\Entity\TagKind;
use App\Form\TagKindType;
use App\Service\TagKindService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TagKindController extends AbstractController
{
    /**
     * @Route("/admin/tag-kind", name="admin_tagKind")
     */
    public function index()
    {
        $tagKinds = $this->getDoctrine()->getRepository(TagKind::class)->findAll();

        return $this->render('tag_kind/index.html.twig', [
            'controller_name' => 'TagKindController',
            'tagKinds' => $tagKinds,
        ]);
    }
}
