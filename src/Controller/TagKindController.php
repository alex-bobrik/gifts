<?php

namespace App\Controller;

use App\Entity\TagKind;
use App\Form\TagKindType;
use App\Service\TagKindService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    /**
     * @Route("/admin/tag-kind/new", name="admin_tagKind_new")
     * @param Request $request
     * @param TagKindService $kindService
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newTagKind(Request $request, TagKindService $kindService)
    {
        $tagKind = new TagKind();

        $form = $this->createForm(TagKindType::class, $tagKind);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $tagKind = $form->getData();
            $kindService->saveTagKind($tagKind);

            return $this->redirectToRoute('admin_tagKind');
        }

        return $this->render('tag_kind/new.html.twig', [
            'controller_name' => 'TagKindController',
            'form' => $form->createView(),
        ]);
    }
}
