<?php


namespace App\Service;


use App\Entity\Item;
use Doctrine\ORM\EntityManagerInterface;

class ItemService
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function saveItem(Item $item)
    {
        $this->em->persist($item);
        $this->em->flush();
    }

    public function deleteItemById(int $id)
    {
        $item = $this->em->getRepository(Item::class)->find($id);

        $this->em->remove($item);
        $this->em->flush();
    }
}