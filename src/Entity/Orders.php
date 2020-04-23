<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderRepository")
 */
class Orders
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $order_date;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $phone_num;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $is_delivery;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $delivery_address;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fullName;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Item", inversedBy="orders")
     */
    private $item;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\OrderKind", inversedBy="orders")
     */
    private $order_kind;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isComplete;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrderDate(): ?\DateTimeInterface
    {
        return $this->order_date;
    }

    public function setOrderDate(?\DateTimeInterface $order_date): self
    {
        $this->order_date = $order_date;

        return $this;
    }

    public function getPhoneNum(): ?string
    {
        return $this->phone_num;
    }

    public function setPhoneNum(?string $phone_num): self
    {
        $this->phone_num = $phone_num;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getIsDelivery(): ?bool
    {
        return $this->is_delivery;
    }

    public function setIsDelivery(?bool $is_delivery): self
    {
        $this->is_delivery = $is_delivery;

        return $this;
    }

    public function getDeliveryAddress(): ?string
    {
        return $this->delivery_address;
    }

    public function setDeliveryAddress(?string $delivery_address): self
    {
        $this->delivery_address = $delivery_address;

        return $this;
    }

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function setFullName(?string $fullName): self
    {
        $this->fullName = $fullName;

        return $this;
    }

    public function getItem(): ?Item
    {
        return $this->item;
    }

    public function setItem(?Item $item): self
    {
        $this->item = $item;

        return $this;
    }

    public function getOrderKind(): ?OrderKind
    {
        return $this->order_kind;
    }

    public function setOrderKind(?OrderKind $order_kind): self
    {
        $this->order_kind = $order_kind;

        return $this;
    }

    public function getIsComplete(): ?bool
    {
        return $this->isComplete;
    }

    public function setIsComplete(?bool $isComplete): self
    {
        $this->isComplete = $isComplete;

        return $this;
    }
}
