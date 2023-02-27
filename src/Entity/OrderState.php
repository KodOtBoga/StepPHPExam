<?php

namespace App\Entity;

use App\Entity\Order;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table('orderstate')]
class OrderState {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(targetEntity: Order::class, inversedBy:'orders')]
    private Order $order;

    #[ORM\Column]
    private string $state;

    #[ORM\Column]
    private User $user;


	public function getId(): ?int {
		return $this->id;
	}

	public function getOrder(): Order {
		return $this->order;
	}

	public function setOrder(Order $order): self {
		$this->order = $order;
		return $this;
	}

	public function getState(): string {
		return $this->state;
	}

	public function setState(string $state): self {
		$this->state = $state;
		return $this;
	}

	public function getUser(): User {
		return $this->user;
	}

	public function setUser(User $user): self {
		$this->user = $user;
		return $this;
	}
}