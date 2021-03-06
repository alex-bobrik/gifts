<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MapOptionRepository")
 */
class MapOption
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Item", mappedBy="mapOption")
     */
    private $items;

//    /**
//     * @ORM\ManyToMany(targetEntity="App\Entity\Item", mappedBy="mapOptions")
//     */
//    private $items;

    public function __construct()
    {
//        $this->items = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Item[]
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(Item $item): self
    {
        if (!$this->items->contains($item)) {
            $this->items[] = $item;
            $item->setMapOption($this);
        }

        return $this;
    }

    public function removeItem(Item $item): self
    {
        if ($this->items->contains($item)) {
            $this->items->removeElement($item);
            // set the owning side to null (unless already changed)
            if ($item->getMapOption() === $this) {
                $item->setMapOption(null);
            }
        }

        return $this;
    }

//    /**
//     * @return Collection|Item[]
//     */
//    public function getItems(): Collection
//    {
//        return $this->items;
//    }
//
//    public function addItem(Item $item): self
//    {
//        if (!$this->items->contains($item)) {
//            $this->items[] = $item;
//            $item->addMapOption($this);
//        }
//
//        return $this;
//    }
//
//    public function removeItem(Item $item): self
//    {
//        if ($this->items->contains($item)) {
//            $this->items->removeElement($item);
//            $item->removeMapOption($this);
//        }
//
//        return $this;
//    }
}
