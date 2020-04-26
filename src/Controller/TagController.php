<?php

namespace App\Controller;

use App\Entity\Tag;
use App\Form\Item\TagType;
use App\Form\SearchType;
use App\Service\TagService;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;

class TagController extends AbstractController
{
    /**
     * @Route("/admin/tags", name="admin_tags")
     */
    public function index(PaginatorInterface $paginator, Request $request, RouterInterface $router)
    {
//        $tags = $this->getDoctrine()->getRepository(Tag::class)->findAll();

        $tagsRepo = $this->getDoctrine()->getRepository(Tag::class);

        $q = $request->get('s');

        if ($q) {
            $tagsQuery = $tagsRepo->createQueryBuilder('t')
                ->select('t')
                ->where('t.name like :name')
                ->setParameter('name', '%'.$q.'%')
                ->getQuery();
        } else {
            $tagsQuery = $tagsRepo->createQueryBuilder('t')
                ->getQuery();
        }

        $form = $this->createForm(SearchType::class, ['query' => $q]);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $search = $form->get('query')->getData();

            return new RedirectResponse($router->generate('admin_tags', ['s' => $search]));
        }

        $tags = $paginator->paginate(
            $tagsQuery,
            $request->query->getInt('page', 1),
            10
        );

        //limit 10

        return $this->render('tag/index.html.twig', [
            'controller_name' => 'TagController',
            'tags' => $tags,
            'form' => $form->createView(),
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

            if
            (
                $tag->getName() ==
                $this->getDoctrine()->getRepository(Tag::class)->findOneBy(['name' => $tag->getName()])->getName()
            )
            {
                $this->addFlash('danger','Тег с таким названием уже существует');

                return $this->redirectToRoute('admin_tag_new');
            }

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
    public function editTag(Request $request, TagService $tagService, int $id, EntityManagerInterface $em)
    {
        $tag = $this->getDoctrine()->getRepository(Tag::class)->find($id);

        $form = $this->createForm(TagType::class, $tag);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $tag = $form->getData();

            $em->persist($tag);
            $em->flush();

            return $this->redirectToRoute('admin_tags');
        }

        return $this->render('tag/edit.html.twig', [
            'controller_name' => 'TagController',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/tags/delete/{id}", name="admin_tag_delete")
     * @param TagService $tagService
     * @param int $id
     * @return Response
     */
    public function deleteTag(TagService $tagService, int $id, EntityManagerInterface $em)
    {
        $tag = $this->getDoctrine()->getRepository(Tag::class)->find($id);

        try {
            $em->remove($tag);
            $em->flush();
        } catch (ForeignKeyConstraintViolationException $ex) {
            $this->addFlash('danger', 'Нельзя удалить, есть связи с подарками');

            return $this->redirectToRoute('admin_tags');
        }

        $this->addFlash('info', 'Тег удален');


        return $this->redirectToRoute('admin_tags');
    }
}
