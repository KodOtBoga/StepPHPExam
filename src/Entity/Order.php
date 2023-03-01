<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table('orders')]
class Order{

	public const STATUS_BASKET = 'basket';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy:'users')]
    private User $user;

    #[ORM\ManyToMany(targetEntity: Product::class, mappedBy: 'orders')]
    private Collection $products;

    #[ORM\OneToOne(targetEntity: OrderState::class)]
    private OrderState $orderState;

	private string $status = self::STATUS_BASKET;

	public function __construct()
	{
		$this->products = new ArrayCollection();
	}

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