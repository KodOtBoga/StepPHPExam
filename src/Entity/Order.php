<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints\Regex;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


#[ORM\Entity]
#[ORM\Table('orders')]
class Order{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy:'users')]
    private User $user;

    #[ORM\Column]
    #[ORM\ManyToMany(targetEntity: Product::class, mappedBy: 'orders')]
    private Collection $products;

    #[ORM\Column]
    #[ORM\ManyToMany(targetEntity: Product::class, mappedBy: 'orders')]
    private OrderState $orderState;


	public function getId(): ?int {
		return $this->id;
	}

	public function getUser(): User {
		return $this->user;
	}

	public function setUser(User $user): self {
		$this->user = $user;
		return $this;
	}

	public function getProducts(): Collection {
		return $this->products;
	}

	public function setProducts(Collection $products): self {
		$this->products = $products;
		return $this;
	}

	public function getOrderState(): OrderState {
		return $this->orderState;
	}

	public function setOrderState(OrderState $orderState): self {
		$this->orderState = $orderState;
		return $this;
	}
}