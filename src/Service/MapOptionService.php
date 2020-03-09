<?php


namespace App\Service;


use App\Entity\MapOption;
use Doctrine\ORM\EntityManagerInterface;

class MapOptionService
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function saveMapOption(MapOption $mapOption)
    {
        $this->em->persist($mapOption);
        $this->em->flush();
    }

}