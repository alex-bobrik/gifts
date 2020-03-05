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

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Tag", inversedBy="items")
     */
    private $tags;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\MapOption", inversedBy="items")
     */
    private $mapOptions;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
        $this->mapOptions = new ArrayCollection();
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

    /**
     * @return Collection|Tag[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        if ($this->tags->contains($tag)) {
            $this->tags->removeElement($tag);
        }

        return $this;
    }

    /**
     * @return Collection|MapOption[]
     */
    public function getMapOptions(): Collection
    {
        return $this->mapOptions;
    }

    public function addMapOption(MapOption $mapOption): self
    {
        if (!$this->mapOptions->contains($mapOption)) {
            $this->mapOptions[] = $mapOption;
        }

        return $this;
    }

    public function removeMapOption(MapOption $mapOption): self
    {
        if ($this->mapOptions->contains($mapOption)) {
            $this->mapOptions->removeElement($mapOption);
        }

        return $this;
    }
}
