<?php


namespace App\Service;


use App\Entity\Tag;
use Doctrine\ORM\EntityManagerInterface;

class TagService
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function saveTag(Tag $tag)
    {
        $this->em->persist($tag);
        $this->em->flush();
    }
}