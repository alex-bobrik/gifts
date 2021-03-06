<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TagRepository")
 */
class Tag
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

//    /**
//     * @ORM\ManyToMany(targetEntity="App\Entity\Item", mappedBy="tags")
//     */
//    private $items;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ItemTag", mappedBy="tag")
     */
    private $itemTags;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TagKind", inversedBy="tags")
     */
    private $tagKind;

    public function __construct()
    {
//        $this->items = new ArrayCollection();
        $this->itemTags = new ArrayCollection();
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
//            $item->addTag($this);
//        }
//
//        return $this;
//    }
//
//    public function removeItem(Item $item): self
//    {
//        if ($this->items->contains($item)) {
//            $this->items->removeElement($item);
//            $item->removeTag($this);
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
            $itemTag->setTag($this);
        }

        return $this;
    }

    public function removeItemTag(ItemTag $itemTag): self
    {
        if ($this->itemTags->contains($itemTag)) {
            $this->itemTags->removeElement($itemTag);
            // set the owning side to null (unless already changed)
            if ($itemTag->getTag() === $this) {
                $itemTag->setTag(null);
            }
        }

        return $this;
    }

    public function getTagKind(): ?TagKind
    {
        return $this->tagKind;
    }

    public function setTagKind(?TagKind $tagKind): self
    {
        $this->tagKind = $tagKind;

        return $this;
    }
}
