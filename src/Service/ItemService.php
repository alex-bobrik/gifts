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

    public function getSelectedTags($info): array
    {
        $result = array();

        foreach ($info as $item) {
            foreach ($item as $tag) {
                $result[] = $tag->getId();
            }
        }

        return $result;
    }

    public function findItemsByTags(array $tags): array
    {
        $qb = $this->em->getRepository(Item::class)
            ->createQueryBuilder('item')
            ->select('item')
            ->innerJoin('item.itemTags', 'itemTags', 'WITH', 'item.id = itemTags.item')
            ->innerJoin('itemTags.tag', 'tag', 'WITH', 'itemTags.tag = tag.id')
            ->where('itemTags.tag IN (:tagsId)')
            ->setParameter('tagsId', $tags)
            ->groupBy('item')
            ->orderBy('count(item)', 'DESC')
            ->getQuery();

        return $qb->getResult();
    }
}