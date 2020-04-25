<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ItemRepository")
 */
class Item
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

//    /**
//     * @ORM\ManyToMany(targetEntity="App\Entity\Tag", inversedBy="items", orphanRemoval=true, cascade={"persist"})
//     */
//    private $tags;

//    /**
//     * @ORM\ManyToMany(targetEntity="App\Entity\MapOption", inversedBy="items", orphanRemoval=true, cascade={"persist"})
//     */
//    private $mapOptions;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ItemTag", mappedBy="item", orphanRemoval=true, cascade={"persist"})
     */
    private $itemTags;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\MapOption", inversedBy="items", cascade={"persist"})
     */
    private $mapOption;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Orders", mappedBy="item")
     */
    private $orders;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    public function __construct()
    {
//        $this->tags = new ArrayCollection();
//        $this->mapOptions = new ArrayCollection();
        $this->itemTags = new ArrayCollection();
        $this->orders = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

//    /**
//     * @return Collection|Tag[]
//     */
//    public function getTags(): Collection
//    {
//        return $this->tags;
//    }
//
//    public function addTag(Tag $tag): self
//    {
//        if (!$this->tags->contains($tag)) {
//            $this->tags[] = $tag;
//        }
//
//        return $this;
//    }
//
//    public function removeTag(Tag $tag): self
//    {
//        if ($this->tags->contains($tag)) {
//            $this->tags->removeElement($tag);
//        }
//
//        return $this;
//    }

//    /**
//     * @return Collection|MapOption[]
//     */
//    public function getMapOptions(): Collection
//    {
//        return $this->mapOptions;
//    }
//
//    public function addMapOption(MapOption $mapOption): self
//    {
//        if (!$this->mapOptions->contains($mapOption)) {
//            $this->mapOptions[] = $mapOption;
//        }
//
//        return $this;
//    }
//
//    public function removeMapOption(MapOption $mapOption): self
//    {
//        if ($this->mapOptions->contains($mapOption)) {
//            $this->mapOptions->removeElement($mapOption);
//        }
//
//        return $this;
//    }

    /**
     * @return Collection|ItemTag[]
     */
    public function getItemTags(): Collection
    {
        return $this->itemTags;
    }

    public function addItemTag(ItemTag $itemTag): self
    {
        if (!$this->itemTags->contains($itemTag)) {
            $this->itemTags[] = $itemTag;
            $itemTag->setItem($this);
        }

        return $this;
    }

    public function removeItemTag(ItemTag $itemTag): self
    {
        if ($this->itemTags->contains($itemTag)) {
            $this->itemTags->removeElement($itemTag);
            // set the owning side to null (unless already changed)
            if ($itemTag->getItem() === $this) {
                $itemTag->setItem(null);
            }
        }

        return $this;
    }

    public function getMapOption(): ?MapOption
    {
        return $this->mapOption;
    }

    public function setMapOption(?MapOption $mapOption): self
    {
        $this->mapOption = $mapOption;

        return $this;
    }

    /**
     * @return Collection|Orders[]
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Orders $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders[] = $order;
            $order->setItem($this);
        }

        return $this;
    }

    public function removeOrder(Orders $order): self
    {
        if ($this->orders->contains($order)) {
            $this->orders->removeElement($order);
            // set the owning side to null (unless already changed)
            if ($order->getItem() === $this) {
                $order->setItem(null);
            }
        }

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }
}
