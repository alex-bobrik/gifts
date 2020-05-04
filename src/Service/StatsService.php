<?php


namespace App\Service;


use App\Entity\Orders;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query;

class StatsService
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getAmountOfOrdersByAllItems(): array
    {
        $query = 'SELECT i, COUNT(i) FROM App\Entity\Item i, App\Entity\Orders o  
                  WHERE o.item = i AND o.isComplete = true GROUP BY o.item';

        $result = $this->em->createQuery($query);

        return $result->getResult();
    }
}