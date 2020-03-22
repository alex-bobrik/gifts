<?php


namespace App\Service;


use App\Entity\TagKind;
use Doctrine\ORM\EntityManagerInterface;

class TagKindService
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function saveTagKind(TagKind $tagKind)
    {
        $this->em->persist($tagKind);
        $this->em->flush();

    }

    public function deleteTagKindById(int $id)
    {
        $tagKind = $this->em->getRepository(TagKind::class)->find($id);

        $this->em->remove($tagKind);
        $this->em->flush();
    }

}