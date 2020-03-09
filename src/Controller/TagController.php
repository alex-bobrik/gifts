<?php

namespace App\Controller;

use App\Entity\Tag;
use App\Form\Item\TagType;
use App\Service\TagService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TagController extends AbstractController
{
    /**
     * @Route("/admin/tags", name="admin_tags")
     */
    public function index()
    {
        $tags = $this->getDoctrine()->getRepository(Tag::class)->findAll();

        return $this->render('tag/index.html.twig', [
            'controller_name' => 'TagController',
            'tags' => $tags,
        ]);
    }

    /**
     * @Route("/admin/tags/new", name="admin_tag_new")
     * @param Request $request
     * @param TagService $tagService
     * @return Response
     */
    public function newTag(Request $request, TagService $tagService)
    {
        $tag = new Tag();
        $form = $this->createForm(TagType::class, $tag);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $tag = $form->getData();
            $tagService->saveTag($tag);

            return $this->redirectToRoute('admin_tags');
        }

        return $this->render('tag/new.html.twig', [
            'controller_name' => 'TagController',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/tags/edit/{id}", name="admin_tag_edit")
     * @param Request $request
     * @param TagService $tagService
     * @param int $id
     * @return Response
     */
    public function editTag(Request $request, TagService $tagService, int $id)
    {
        $tag = $this->getDoctrine()->getRepository(Tag::class)->find($id);

        $form = $this->createForm(TagType::class, $tag);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $tag = $form->getData();
            $tagService->saveTag($tag);

            return $this->redirectToRoute('admin_tags');
        }

        return $this->render('tag/edit.html.twig', [
            'controller_name' => 'TagController',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/tags/delete/{id}", name="admin_tag_delete")
     */
    public function deleteTag()
    {
        return $this->render('tag/index.html.twig', [
            'controller_name' => 'TagController',
        ]);
    }
}
